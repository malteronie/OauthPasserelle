## Reste à faire
- Add column table users pour OpenId
   <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css"  rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" rel="stylesheet" />

- Factoriser les routes (prefix, name etc...)

- Passer les permissions dans les fichiers Policies et route en ressource

- Préciser procèdure install tailwind lors mise en place squelette

- Reprendre les input en shared

- Spatie wildcards??? 

- Spatie givePermissionTo et Sync?

- Livewire : voir qui est en ligne??? OUI/NON?

# Avant déploiement

## Modification du fichier env

1. Application
    - APP_NAME  
    - APP_ONLINE choisir true ou false pour adapter les éventuels notif mails etc...

2. MindefConnect
    - KEYCLOAK_CLIENT_ID
    - KEYCLOAK_CLIENT_SECRET
    - KEYCLOAK_REDIRECT_URI
    - KEYCLOAK_BASE_URL
    - KEYCLOAK_REALM

3. Mail
    - MAIL_FROM_ADDRESS
    - MAIL_FROM_NAME

4. BdD
    - DB_DATABASE

5. Adresse mail admin fonctionnel
    - MAIL_ADMIN_APPLI

## Modification du fichier Seeder

1. Information de l'administrateur par defaut
    - Nom, identifiant, mail

## Mode hors ligne

1. Par défaut les listeners sont pour mode intradef donc inverser les versions commentées des listeners

## Mails

1. Modification les blade des divers mails
2. Mettre l'adminmetier en from lorsque nécessaire
