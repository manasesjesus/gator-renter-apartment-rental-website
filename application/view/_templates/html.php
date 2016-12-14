<!DOCTYPE html>
<!-- Created by SFSU             -->
<!-- Modified by Manasés Galindo -->
<html lang="en-US" ng-app="gatorRenter">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gator Renter</title>
    <link rel="stylesheet" href="<?php echo URL; ?>css/style.css">
    <link rel="stylesheet" href="<?php echo URL; ?>css/buttons.css">
    <link rel="stylesheet" href="<?php echo URL; ?>css/font-awesome/css/font-awesome.min.css">
</head>
<body>
    <main class="flex column" ng-view></main>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular-resource.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular-route.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/danialfarid-angular-file-upload/12.2.13/ng-file-upload.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyBaa7TY_TGjYeN6LtTaBRItEvI11Iz34DY"></script>
    <script src="<?php echo URL; ?>js/angular-storage.min.js"></script>
    <script src="<?php echo URL; ?>js/ng-map.min.js"></script>
    <script src="<?php echo URL; ?>js/app.js"></script>
    <script src="<?php echo URL; ?>components/home/home.ctrl.js"></script>
    <script src="<?php echo URL; ?>components/profile/admin.ctrl.js"></script>
    <script src="<?php echo URL; ?>components/profile/profile.ctrl.js"></script>
    <script src="<?php echo URL; ?>components/apartment/apartment.ctrl.js"></script>
    <script src="<?php echo URL; ?>components/apartment/apartment.service.js"></script>
    <script src="<?php echo URL; ?>components/common/helper.service.js"></script>
    <script src="<?php echo URL; ?>components/service/user.service.js"></script>
</body>
</html>