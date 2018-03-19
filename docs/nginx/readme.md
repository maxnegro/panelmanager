# Configurazione NGINX
Per il corretto funzionamento dell'applicazione è necessario configurare opportunamente
un'istanza di Nginx per permettere il reverse proxy verso i pannelli.

Per il websocket proxy è necessario compilare nginx con l'estensione *websockify-nginx-module*
disponibile su GitHub: [tg123/websockify-nginx-module](https://github.com/tg123/websockify-nginx-module).

Inoltre è necessario utilizzare l'estensione lua per Nginx. Ad essa va aggiunto
il modulo resty-mysql che si può installare con

```bash
luarocks install lua-resty-mysql
```
Nel file di configurazione di Nginx (ie */etc/nginx/sites-available/default*) vanno inserite
le seguenti variabili di configurazione, oltre alle due location sotto specificate:

```nginx
set $dbhost 'ip_del_server_mysql';
set $dbport 3306;
set $dbname 'nome_del_database';
set $dbuser 'utente_mysql';
set $dbpass 'password_mysql';

location /websockify {
    set $vnc_addr '';
    access_by_lua '
        -- read from url params
        local args = ngx.req.get_uri_args()
        local token = args["t"]

        local mysql = require "resty.mysql"
        local db, err = mysql:new()
        if not db then
            ngx.say("failed to instantiate mysql: ", err)
            return
        end
        local ok, err, errcode, sqlstate = db:connect {
            host = ngx.var.dbhost,
            port = ngx.var.dbport,
            database = ngx.var.dbname,
            user = ngx.var.dbuser,
            password = ngx.var.dbpass,
            charset = "utf8",
            max_packet_size = 1024 * 1024,
        }
        if not ok then
            ngx.say("failed to connect: ", err, ": ", errcode, " ", sqlstate)
            return
        end

        -- ngx.say("connected to mysql.")

        -- run a select query, expected about 1 row in
        -- the result set:
        local sql = "SELECT ip, port FROM websocket WHERE token = " .. ngx.quote_sql_str(token) .. " AND validUntil > " .. ngx.time()
        res, err, errcode, sqlstate =
            db:query(sql, 1)
        if not res then
            ngx.say("bad result: ", err, ": ", errcode, ": ", sqlstate, ".")
            return
        end

        if table.getn(res) == 1 then
            local addr =  res[1].ip .. ":" .. res[1].port
            ngx.var.vnc_addr = addr
        else
            ngx.status = 403
            ngx.say("You don\'t exist go away!")
            ngx.exit(ngx.OK)
        end
    ';

    websockify_pass $vnc_addr;
}

location ~ ^/webproxify/([-0-9a-zA-z]+)/(.*)$ {
    set $proxy_addr '';
    set $token $1;
    set $path $2;

    access_by_lua '
        local token = ngx.var.token;

        local mysql = require "resty.mysql"
        local db, err = mysql:new()
        if not db then
            ngx.say("failed to instantiate mysql: ", err)
            return
        end
        local ok, err, errcode, sqlstate = db:connect {
            host = ngx.var.dbhost,
            port = ngx.var.dbport,
            database = ngx.var.dbname,
            user = ngx.var.dbuser,
            password = ngx.var.dbpass,
            charset = "utf8",
            max_packet_size = 1024 * 1024,
        }
        if not ok then
            ngx.say("failed to connect: ", err, ": ", errcode, " ", sqlstate)
            return
        end

        -- ngx.say("connected to mysql.")

        -- run a select query, expected about 1 row in
        -- the result set:
        local sql = "SELECT ip, port FROM webproxy WHERE token = " .. ngx.quote_sql_str(token)  .. " AND validUntil > " .. ngx.time()
        res, err, errcode, sqlstate = db:query(sql, 1)
        if not res then
            ngx.say("bad result: ", err, ": ", errcode, ": ", sqlstate, ".")
            return
        end

        if table.getn(res) == 1 then
            local addr =  res[1].ip .. ":" .. res[1].port
            -- Refresh token validity for further requests
            sql = "UPDATE webproxy SET validUntil = " .. ngx.time() + 60 .. " WHERE token = " .. ngx.quote_sql_str(token);
            res, err, errcode, sqlstate = db:query(sql, 1);
            ngx.var.proxy_addr = addr
        else
            ngx.status = 403
            ngx.say("You don\'t exist go away!")
            ngx.exit(ngx.OK)
        end
    ';

    proxy_set_header Accept-Encoding "";
    proxy_buffering off;
    proxy_connect_timeout 300;
    proxy_send_timeout 300;
    proxy_read_timeout 300;
    send_timeout 300;
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_pass_header Set-Cookie;

    proxy_pass http://$proxy_addr/$path;
    proxy_redirect off;
}
```
