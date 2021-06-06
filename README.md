# sae_store - Costum CMS

Plantbase.at

## Models / Datenbanktabellen

+ User - users
  + id* INT A_I PK
  + email* VARCHAR(255) UK
  + password* (Hash) VARCHAR(255)
  + firstname* VARCHAR(255)
  + secondname* VARCHAR(255)
  + phone* VARCHAR(255)
  + address*  VARCHAR(255)
  + country* VARCHAR(255)
  + zip* VARCHAR(255)
  + is_admin BOOL NULL default:0
  + crdate* (Creation Date) TIMESTAMP
  + tstamp* (Zeitpunkt des letzten Updates) TIMESTAMP ou_CT
  + deleted_at TIMESTAMP NULL

+ Product - products
  + id* INT A_I PK
  + name* VARCHAR(255)
  + slug* VARCHER(255) UK
  + description TEXT Null
  + price* INT 
  + category* INT FK:categories.id
  + watering*
  + sun_location*
  + size* (größe der Pflanze in cm)
  + stock INT NULL
  + crdate* TIMESTAMP
  + tstamp* (Zeitpunkt des letzten Updates) TIMESTAMP ou_CT
  + deleted_at TIMESTAMP NULL

+ Category - categories
  + id* INT A_I PK
  + title* VARCHAR(255)
  + slug* VARCHAR(255) UK
  + description TEXT NULL
  + crdate* TIMESTAMP
  + tstamp* (Zeitpunkt des letzten Updates) TIMESTAMP ou_CT
  + deleted_at TIMESTAMP NULL

+ Picture - pictures
  + id* INT A_I PK
  + name* TEXT
  + path* TEXT
  + alttext TEXT NULL
  + crdate* TIMESTAMP
  + tstamp* (Zeitpunkt des letzten Updates) TIMESTAMP ou_CT
  + deleted_at TIMESTAMP NULL

+ products_pictures_map
  + id* INT A_I PK
  + productes_id* INT FK:products.id
  + pictures_id* INT FK:pictures.id

+ Order - orders
  + id* INT A_I PK
  + user_id* INT FK:users.id
  + firstname* VARCHAR(255)
  + secondname* VARCHAR(255)
  + email* VARCHAR(255)
  + phone* VARCHAR(255)
  + address*  VARCHAR(255)
  + country* VARCHAR(255)
  + zip* VARCHAR(255)
  + alt_address  VARCHAR(255)
  + alt_country VARCHAR(255)
  + alt_zip VARCHAR(255)
  + products* (JSON mit allen bestellten Produkten) TEXT
  + status NULL 
  + crdate* (Creation Date) TIMESTAMP
  + tstamp* (Zeitpunkt des letzten Updates) TIMESTAMP ou_CT
  + deleted_at TIMESTAMP NULL

## Controllers
C Create R Read/List U Update D Delete
+ UserController CRUD
+ ProductController CRUD
+ PictureController CRUD
+ OrderController CRUD

## Core
+ Bootstrap
+ Router
+ Database
+ View
+ Config
+ Session
+ Validator
+ AbstractModel
+ AbstractUser
+ AbstractFile
+ SoftDelete Trait

## Views / Seiten
+ Startseite
+ Auflistung aller Produkte
+ Produktseite
+ Auflistung aller Produkte einer Kategorie
+ Warenkorb
+ Checkout
+ Login
+ Logout
+ User: Bestellübersicht

+ Admin: Auflistung aller Bestellungen
+ Admin: Order edit
+ Admin: Produkt Liste
+ Admin: Produkt edit (mit Bildern)
+ Admin: Produkt create
+ Admin: User Liste
+ Admin: User Edit
+ Admin: User Create