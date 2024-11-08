{ pkgs, lib, config, inputs, ... }:
let
  dbUser = "material";
  dbPassword = "material";
  dbName = "material";
in
{
  packages = with pkgs; [ 
    git 
    symfony-cli
  ];

  enterShell = ''
    sudo sysctl -w net.ipv4.ip_unprivileged_port_start=0
    echo "If you installed this project for the first time, please run 'composer install'."
  '';

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
        "pm" = "dynamic";
        "pm.max_children" = 5;
        "pm.start_servers" = 2;
        "pm.min_spare_servers" = 1;
        "pm.max_spare_servers" = 5;
      };
    };
  };

  # create services
  services = {
    caddy = {
      enable = true;
      virtualHosts."http://localhost" = {
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
      };
    };
  };
}
