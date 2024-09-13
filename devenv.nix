{ pkgs, lib, config, inputs, ... }:
let
  dbUser = "material";
  dbPassword = "material";
in
{
  # https://devenv.sh/basics/
  env.GREET = "devenv";

  # https://devenv.sh/packages/
  packages = [ pkgs.git ];

  # https://devenv.sh/languages/
  # languages.rust.enable = true;

  # https://devenv.sh/processes/
  # processes.cargo-watch.exec = "cargo-watch";

  # https://devenv.sh/services/
  # services.postgres.enable = true;

  # https://devenv.sh/scripts/
  scripts.hello.exec = ''
    echo hello from $GREET
  '';

  enterShell = ''
    hello
    git --version
  '';

  # https://devenv.sh/tests/
  enterTest = ''
    echo "Running tests"
    git --version | grep --color=auto "${pkgs.git.version}"
  '';

  # https://devenv.sh/pre-commit-hooks/
  # pre-commit.hooks.shellcheck.enable = true;

  # See full reference at https://devenv.sh/reference/options/

  scripts.caddy-allow-port.exec = ''sudo sysctl -w net.ipv4.ip_unprivileged_port_start=0'';

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
        extraConfig = ''
          root * .
          php_fastcgi unix/${config.languages.php.fpm.pools.web.socket}
          file_server
        '';
      };
    };
    mysql = {
      enable = true;
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
