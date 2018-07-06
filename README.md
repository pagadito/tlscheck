# Requerimiento TLSv1.2
El Consejo de Estándares de Seguridad de la Industria de Tarjetas de Pago (PCI SSC) exige que todos los procesadores de tarjetas de crédito deben retirar las primeras versiones de TLS de sus servicios.

En Pagadito la seguridad, confiabilidad y cumplimiento son nuestros valores principales y tomamos muy en serio la protección de los datos de nuestros clientes. Pagadito esta actualizando sus servicios para requerir TLS 1.2 para todas las conexiones HTTPS.

## ¿Qué significa esto para los Comercios Pagadito?
Los comercios deben verificar que sus sistemas puedan usar el protocolo TLSv1.2 en la comunicación con Pagadito. **Toda transacción proveniente de protocolos no soportados, serán rechazadas.**

Utilice las siguientes herramientas para verificar la preparación de TLSv1.2 en su entorno:
* [Acceso remoto SSH](#acceso-remoto-ssh)
* [PHP](#php)
* [PAGADITO POS PC](#pagadito-pos-pc)

* * *
### Acceso Remoto SSH
* [Requerimientos SSH](#requerimientos-ssh)
* [Lineamientos SSH](#lineamientos-ssh)

#### Requerimientos SSH
* Acceso remoto mediante SSH a su entorno de trabajo.
* Paquete de herramientas openssl instaladas.

#### Lineamientos SSH
1. Ingrese a la consola SSH de su servidor
2. Ejecute el siguiente comando

    ```sh
    openssl s_client -connect sandbox.pagadito.com:443
    ```

    * Un resultado exitoso:

    ```sh
    CONNECTED(00000003)
    ...
    SSL-Session:
        Protocol : TLSv1.2
    ...
    ```

    * Un resultado fallido:

    ```sh
    CONNECTED(00000003)
    139788311062176:error:1409E0E5:SSL routines:SSL3_WRITE_BYTES:ssl handshake failure:s3_pkt.c:599:
    ...
    Secure Renegotiation IS NOT supported
    SSL-Session:
        Protocol  : TLSv1.1

    ```

* * *

### PHP
* [Requerimientos PHP](#requerimientos-php)
* [Lineamientos PHP](#lineamientos-php)

#### Requerimientos PHP
* PHP utiliza la librería cURL que requiere una versión OpenSSL 1.0.1 o mayor.
* Usted necesita [actualizar su librería SSL/TLS](http://curl.haxx.se/docs/ssl-compared.html)
* Usted necesita Acceso remoto mediante SSH o FTP a su entorno de trabajo.

#### Lineamientos PHP
1. Descargue [tls1_2_check.php](php/tls1_2_check.php)
2. Ejecute el Script en su entorno
3. Desde una consola con acceso remoto ssh, ejecute el comando:

    ```sh
        php -f tls1_2_check.php
    ```
4. En caso no tenga acceso ssh, cargue el script [tls1_2_check.php](php/tls1_2_check.php) mediante FTP, y luego cargue la url de su sitio en su navegador
5. Verifique los resultados

    * Un resultado exitoso:
    ```sh
    System Info
    ---------------------------
    Host: x86_64-pc-linux-gnu
    Operating System: Linux
    PHP version: 5.3.10-1ubuntu3.26
    cURL Version: 7.22.0
    SSL Version: OpenSSL/1.0.1

    Trying connection with Pagadito...
    ---------------------------
    TLS test(default TLS 1.2) :OK
    TLS test(TLSv1.2 forced) : OK
    ```

    * Un resultado fallido:
    ```sh
    System Info
    ---------------------------
    Host: x86_64-pc-linux-gnu
    Operating System: Linux
    PHP version: 5.3.10-1ubuntu3.26
    cURL Version: 7.22.0
    SSL Version: OpenSSL/0.9.8zf

    Trying connection with Pagadito...
    ---------------------------
    TLS test(default ) :cURL Error! #35 : Unknown SSL protocol error in connection to sandbox.pagadito.com:443
    TLS test(TLSv1.2 forced) :cURL Error! #35 : Unknown SSL protocol error in connection to sandbox.pagadito.com:443
    ```
* * *

### PAGADITO POS PC
* [Requerimientos POS](#requerimientos-pos)
* [Lineamientos POS](#lineamientos-pos)

#### Requerimientos POS
* Herramienta PagaditoChecker [PAGADITO_POS_PC/CheckerPagadito.zip](PAGADITO_POS_PC/CheckerPagadito.zip)

#### Lineamientos POS
1. Descargue la herramienta desde aquí: [PAGADITO_POS_PC/CheckerPagadito.zip](PAGADITO_POS_PC/CheckerPagadito.zip)
2. Descomprima el archivo CheckerPagadito.zip
3. Abra el archivo ejecutable CheckerPagadito/CheckerPagadito.exe
4. Haga clic en el botón PROBAR

    * Un resultado exitoso mostrará el mensaje:

    ```
    Todo bien, cumple con los requisitos.
    ```
    *Captura de ejemplo:[PAGADITO_POS_PC/prueba_satisfactorio.png](PAGADITO_POS_PC/prueba_satisfactorio.png)*

    * Un resultado fallido mostrará el mensaje:
    ```
    Contacte a soporte técnico
    ```
    *Captura de ejemplo:[PAGADITO_POS_PC/prueba_fallida.png](PAGADITO_POS_PC/prueba_fallida.png)*

* * *

## ¿Qué debe hacer si obtuvo un resultado fallido?
1. Asegúrese de utilizar las [últimas versiones de nuestras APIs, Plugins o Demos](https://dev.pagadito.com/index.php?mod=docs&hac=des)
2. Realice transacciones de prueba en ambiente Sandbox (Este ambiente ya tiene aplicado el cambio de TLS y te dará error de conexión si tu sitio web se intenta comunicar con Pagadito mediante protocolos no soportados)
3. Contacte a su proveedor de hosting para que le brinden una solución que sea compatible con TLS v1.2

## ¿Necesita apoyo adicional?
Si tiene alguna pregunta o necesita apoyo para solventar este tema, contacte a nuestro equipo técnico para que le apoye en la solución.

* e-mail: developers@pagadito.com
* Teléfono: +503 2264-7032
