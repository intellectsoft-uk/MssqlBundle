Install
-------

Add the **isoft/mssql-bundle** into **composer.json**

    "require": {
        ....
        "isoft/mssql-bundle": "master-dev"
    },

Usage
-----

Add to section doctrine - dbal in **config.yml** option **driver_class**

    doctrine:
        dbal:
            driver_class:   \Realestate\MssqlBundle\Driver\PDODblib\Driver
            host: %database_host%
            user: %database_user%
            password: %database_password%
            # options:
            #    ansi_nulls: on
            #    ansi_warnings: on
            #    ansi_padding: on
            #    concat_null_yields_null: on
            #    quoted_identifier: on

The %database_driver% must not be set, neither the %charset% parameter, as for stackoverflow.com/questions/8492941/doctrine-2-how-to-add-custom-dbal-driver#answer-8731924

The connection options (ansi_nulls and ansi_warnings) may be configured for MSSQL to ON|OFF

*************************
In app/AppKernel.php registerBundles(), add the following line:

    $bundles = array(
        ...
        new Realestate\MssqlBundle\RealestateMssqlBundle(),
        ...
    );

*************************
This driver requires version 8.0 (from http://www.ubuntitis.com/?p=64) as default 4.2 version does not have UTF support

An example of freetds.conf (/etc/freetds/freetds.conf) is:

    [mssql_server]
        host = xxx.xxx.xxx.xxx
        port = 1433
        tds version = 8.0
        client charset = UTF-8
        text size = 20971520

************************
can't use nvarchar!!


*************************
In SQL 2000 SP4 or newer, SQL 2005 or SQL 2008, if you do a query that returns NTEXT type data, you may encounter the following exception:
_mssql.MssqlDatabaseError: SQL Server message 4004, severity 16, state 1, line 1:
Unicode data in a Unicode-only collation or ntext data cannot be sent to clients using DB-Library (such as ISQL) or ODBC version 3.7 or earlier.

It means that SQL Server is unable to send Unicode data to FTREETDS, because of shortcomings of FTREETDS. You have to CAST or CONVERT the data to equivalent NVARCHAR data type, which does not exhibit this behaviour.



