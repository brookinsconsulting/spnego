http://en.wikipedia.org/wiki/SPNEGO

Example Apache configuration:

# Try Kerberos single sign-on
AuthType Kerberos
AuthName "Kerberos login"
Krb5Keytab /etc/krb5.keytab
KrbVerifyKDC on
KrbAuthRealms EXAMPLE.COM
KrbServiceName HTTP/test.example.com@EXAMPLE.COM
Require valid-user

Example /etc/krb5.conf

[libdefaults]
        default_realm = EXAMPLE.COM

[realms]
        EXAMPLE.COM = {
                kdc = KDC.EXAMPLE.COM
        }

[logging]
    kdc = FILE:/var/log/krb5/krb5kdc.log
    default = FILE:/var/log/krb5/krb5kdc.log

[appdefaults]
   kinit = {
       debug = true
   }