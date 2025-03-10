# A propos du test

### Users "administrateurs"

- Les utilisateurs "administrateurs" sont en fait les users créer automatiquement par laravel à la création de
  l'application. Il suffit de se logger ou alors de créer un nouvel user et de conserver le token que renvoie la route
  POST : /api/register et POST : /api/login pour avoir accès aux routes qui nécessite une authetnification.
- Il existe une mini api pour gérer les tokens avec Passport. J'ai utilisé Passeport au lieu de Sanctum pour avoir une
  gestion de l'oauth2 directement dans le projet, mais ce n'est pas exploité à son plein potentiel.

### Les profils

- Les routes sont toutes sous le prefix /api/profiles
- J'ai laissé la route "index()" être la route publique qui dessert tous les profils "actif" sans montrer leurs status
  sauf si vous êtes authentifiés.
- Cependant, je n'ai pas mis ce filtre pour la récupération d'un profile unique (l'affichage du status est là uniquement
  si l'user est authentifié). Je ne savais pas trop si la condition sur la liste des profils serait à appliqué sur les
  profile uniques aussi.
- Les autres endpoint pour modifier les resources sont protégés par une auth basique avec un bearer token donné par la
  mini api au-dessus

#### Les images

Pour les images, je suis parti du principe qu'on les stocke dans le dossier publique et qu'on lie le lien direct de
l'image plutôt qu'un blob en db. On peut imaginer remplacer ce processus par des liens amazone S3 afin de ne pas avoir
besoin de beaucoup de stockage pour l'app.

### Test, seeders, factory

Je dois admettre que je n'ai jamais utilisé ces outils dans mon précédent travail. J'ai ajouté pour le test afin de
découvrir et de faire au mieux. L'app a un coverage de 82%.
Le seeder des users créer 2 users qui serve à l'authentification sans avoir à créer de nouveau user à chaque fois.
J'ai préféré utiliser une db Sqlite pour exécuter les tests et éviter de polluer la db.

