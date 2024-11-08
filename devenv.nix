{ pkgs, lib, config, inputs, ... }:
let
  dbUser = "material";
  dbPassword = "material";
  dbName = "material";
  dbPort = "3306";
  host = "127.0.0.1";
in
{
  dotenv.disableHint = true;

  packages = with pkgs; [
    git
    symfony-cli
  ];

  enterShell = ''sudo sysctl -w net.ipv4.ip_unprivileged_port_start=0'';

  scripts = {
    load-db.exec = ''
      echo "Make sure devenv up is running in another window."
      echo "Importing Database..."
      mysql -u material -pmaterial material < ./src/database.sql
      echo "Imported Database."
    '';
    caddy-allow-port.exec = ''sudo sysctl -w net.ipv4.ip_unprivileged_port_start=0'';
  };

  languages.php = {
    enable = true;
    fpm.pools.web = {
      settings = {
        "clear_env" = "no";
        "pm" = "dynamic";
        "pm.max_children" = 5;
        "pm.start_servers" = 2;
        "pm.min_spare_servers" = 1;
        "pm.max_spare_servers" = 5;
      };
    };
  };

  env = {
    APP_URL = "http://${host}";
    DATABASE_URL="mysql://material:material@127.0.0.1:3306/material?serverVersion=10.11.2-MariaDB&charset=utf8mb4";
    # DATABASE_URL = "mysql://${dbUser}:${dbPassword}@${host}:${dbPort}/${dbName}?serverVersion=8.0.32&charset=utf8mb4";
    #DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8.0.32&charset=utf8mb4"
  };

  # create services
  services = {
    caddy = {
      enable = true;
      virtualHosts."http://${host}" = {
#         extraConfig = ''
#           root * .
#           php_fastcgi unix/${config.languages.php.fpm.pools.web.socket}
#           file_server
#         '';
        extraConfig = ''
          @default {
            not path /theme/* /media/* /thumbnail/* /bundles/* /css/* /fonts/* /js/* /sitemap/*
          }

          root * public
          php_fastcgi @default unix/${config.languages.php.fpm.pools.web.socket} {
              trusted_proxies private_ranges
          }
          file_server
        '';
      };
    };
    mysql = {
      enable = true;
      initialDatabases = [ { name = dbName; } ];
      ensureUsers = [ {
        name = dbUser;
        password = dbPassword;
        ensurePermissions = { "*.*" = "ALL PRIVILEGES"; };
      }];
      settings.mysqld = {
        port = dbPort;
      };
    };
  };
}
