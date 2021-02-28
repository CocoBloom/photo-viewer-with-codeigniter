# Photo Viewer Application - backend

A mappa a Photo Viewer projekt backend részét tartalmazza. A telepítési útmutatóban megtalálható lépések elvégzésevel az migrációs táblázatok elérhetővé válnak és adatbázis műveletek végrejathatóak. A frontend részt tartalmazó mappa klónozása után a teljes alkalmazás a böngészőből elérhető: Photo Viewer Application - frontend: https://github.com/CocoBloom/photo-viewer-react.git

## Telepítési útmutató:

### git clone https://github.com/CocoBloom/photo-viewer-with-codeigniter.git
### composer install
  A command végrehajtásával a függőségek telepítődnek a mappába.
### Szabadonválasztott adatbáziskezelőben adatbázis kapcsolat létrehozása.
  A projekt során a PHPStorm beépített kezezlőjét használtam.
### .env fájl létrehozása
  A root mappában megtalálható env fájl mintaként használható. A projekt során mariaDB-t használtam. 
  A szükséges beállítások:
      database.default.hostname = 
      database.default.database = 
      database.default.username = 
      database.default.password =
      database.default.DBDriver = 
### php spark migrate
  Migrációs táblák létrehozása a parancs végrejatásával.
Következő lépésként válaszható a táblák feltöltése paranccsal vagy már az applikáción keresztül az új fotó hozzáadása funckió használatával.
Első esetben a következő parancs futtatása szükséges, mielőtt elindítjuk a szervert:
### php spark db:seed PhotoSeeder
### php spark serve
  Szerver indítása
  
(Megjegyzés: a backend 80-as porton működik. Abban az esetben, ha a 80-as port használatban van a felhasználó gépén, akkor frontenden cserélni kell az elérési útvonalat. Ennek helye a root mappából indulva: ./src/services/ApiService.js. Cserélendő: const URL = 'http://localhost:8080' .)
  
  


