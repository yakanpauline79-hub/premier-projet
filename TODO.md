# Task: Arranger le code (images et vidéo)

## Étapes

### index.html
- [x] Fixer le `</div>` orphelin dans la section home
- [x] Corriger l'id de section `popular-destionation` -> `popular-destination`
- [x] Réparer les liens `href="a"` cassés
- [x] Ajouter les images inutilisées (`cathedral de yaounde.jpg`, `home.jpg`) comme nouvelles destinations
- [x] Nettoyer la balise vidéo dans la section About
- [x] Corriger le lien "Reserve Now" vers reservation.php

### reservation.php
- [x] Retirer `require_once 'vendor/autoload.php'` (fichier inexistant)
- [x] Corriger le gestionnaire MODIFICATION (variables et requête UPDATE sur table `reservation`)
- [x] Corriger la requête LECTURE pour lire de la table `reservation`
- [x] Corriger le nom de colonne invalide `id reservation`
- [x] Corriger les colonnes du tableau pour correspondre aux champs reservation

### styles.css
- [x] Nettoyage mineur pour la cohérence

### Connexion des pages
- [x] Lien "Reserve Now" dans index.html vers reservation.php
- [x] Lien "Retour à l'accueil" dans reservation.php vers index.html

### Amélioration du design
- [x] Typographie (Poppins) et base
- [x] Header avec blur et liens animés
- [x] Hero avec overlay sombre
- [x] Formulaire find_trip amélioré
- [x] Cartes destination arrondies + hover
- [x] Formulaire contact stylisé
- [x] Footer amélioré
- [x] Responsive amélioré

### Espace vidéo (About)
- [x] Cadre vidéo (aspect-ratio 16/10, bordures, coins arrondis)
- [x] Décors gradient et contour autour de la vidéo
- [x] Badge lecture superposé sur la vidéo

### Bouton "see" -> reservation.php
- [x] Formulaire find_trip en POST vers reservation.php
- [x] Champs Region/City/Site avec attributs `name`
- [x] Bouton submit nommé `ajouter` pour déclencher l'insertion

### Arrangement de reservation.php
- [x] Thème sombre teal cohérent avec le site principal (Poppins, #29d9d5)
- [x] Formulaire en grille deux colonnes avec labels
- [x] Tableau stylisé (en-tête gradient, hover, boutons d'action)
- [x] Champ Payement en liste déroulante (Carte / Mobile Money / Cash)
- [x] Disposition responsive
