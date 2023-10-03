=== Correos Oficial ===
Contributors: correos
Tags: shipping, woocommerce
Requires at least: 5.4.2
Tested up to: 5.8.3
Stable tag: 1.0.12
Requires PHP: 7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Gestión de envíos con Correos para WooCommerce

== External services ==

The plugin use correos.es web services to manage the shipping. Only the data necessary to manage a shipment will be sent.

Correos service:
https://www.correos.es

Correos service's terms of use:
https://www.correos.es/ss/Satellite/site/pagina-aviso_legal/sidioma=es_ES

== Installation ==

1. Navigate to _Dashboard – Plugins – Add New_;
2. Search for _Correos Oficial_;
3. Click _Install_, then _Activate_.

== Changelog ==
= 1.0.12 =
Added functionality to make the Personal ID(DNI/NIF) field required or activate an existing Personal ID(DNI/NIF) field.

= 1.0.11 =
Minor error, occurred when installing the module in some PHP versions(7.2.34).

= 1.0.10 =
Added new fields for Customs documentation for returns: Tariff number and Description. 

= 1.0.9 =
Added new fields for Customs documentation: Tariff number and Customs Reference Consignor. 

= 1.0.8.1 =
Fixed problem with required destinatary DNI-NIF field. 
Show when destination is TF, GC, CE and ML provinces. It is not required.

= 1.0.8 =
Fixed problem with RMA/return label generation, Return Label button.
Fixed function to get Content Declaration.

= 1.0.7 =
Changed destination email for new customer registration request

= 1.0.6 =
Required NIF/DNI and Custom Documentation for Shipping Zones

= 1.0.5 =
New logos of Correos.

= 1.0.4 =
Fix citypaq shipping code

= 1.0.3 =
Extend allowed charcodes in Correos password

= 1.0.2 =
Improve send size package in preregister
Add setting for activate alternative ssl connection to web service
Fix address format in Correos metabox order

= 1.0.1 =
Fix check default sender

= 1.0.0 =
Initial release.
