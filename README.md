IntegerNet_Haendlerbund
=======================
Magento legal text integration from Händlerbund service.

Facts
-----
- version: 1.0.0
- extension key: IntegerNet_Haendlerbund
- [extension on GitHub](https://github.com/integer-net/Haendlerbund)

Description
-----------

Requirements
------------
- PHP >= 5.2.0
- PHP <= 5.5.x

Compatibility
-------------
- Magento 1.4.0.0
- Magento 1.4.0.1
- Magento 1.4.1.0
- Magento 1.4.1.1
- Magento 1.4.2.0
- Magento 1.5.0.1
- Magento 1.5.1.0
- Magento 1.6.0.0
- Magento 1.6.1.0
- Magento 1.6.2.0
- Magento 1.7.0.0
- Magento 1.7.0.1
- Magento 1.7.0.2
- Magento 1.8.0.0
- Magento 1.8.1.0

Installation Instructions
-------------------------
1. Install the extension by copying all the files in `src` directory into your Magento document root.
2. Clear the cache and start a new admin session (logout from the admin panel and then login again).
3. Configure the extension under ***System >> Configuration >> Händlerbund***

Uninstallation
--------------
1. Remove all extension files from your Magento installation
 - src/app/code/community/IntegerNet/Haendlerbund
 - src/app/design/adminhtml/default/default/template/integernet_haendlerbund
 - src/app/etc/modules/IntegerNet_Haendlerbund.xml
 - src/app/locale/de_DE/IntegerNet_Haendlerbund.csv
 - src/app/locale/en_US/IntegerNet_Haendlerbund.csv
2. Remover entitys from `core_config_data` with `path` stars with `integernet_haendlerbund/%`
3. Clear the cache and start a new admin session (logout from the admin panel and then login again).

Support
-------
If you have any issues with this extension, open an issue on [GitHub](https://github.com/integer-net/Haendlerbund/issues).

Contribution
------------
Any contribution is highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developer
---------
Soeren Zorn
Viktor Franz

WWW [http://www.integer-net.de/](http://www.integer-net.de/)
Twitter [@integer_net](https://twitter.com/integer_net)

Licence
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)

Copyright
---------
(c) 2013-2014 integer_net GmbH
