<!DOCTYPE html>
<html lang="en-US" ng-app="gatorRenter">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gator Renter</title>
  <link rel="stylesheet" href="<?php echo URL; ?>css/style.css">
  <link rel="stylesheet" href="<?php echo URL; ?>css/buttons.css">
</head>
<body>
  <main class="flex column" ng-view></main>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular-resource.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular-route.min.js"></script>
  <script src="<?php echo URL; ?>js/ng-map.min.js"></script>
  <script src="http://maps.googleapis.com/maps/api/js?sensor=false&language=en"></script>
  <script src="<?php echo URL; ?>js/app.js"></script>
  <script src="<?php echo URL; ?>components/home/home.ctrl.js"></script>
  <script src="<?php echo URL; ?>components/apartment/apartment.ctrl.js"></script>
  <script src="<?php echo URL; ?>components/apartment/apartment.service.js"></script>
</body>
</html>
