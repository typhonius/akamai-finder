<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Akamai finder</title>

    <!-- GA -->
    <!--<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-FILL-ME', 'auto');
      ga('send', 'pageview');
    </script>-->
    <!-- jQuery -->
    <script src="js/jquery-1.4.4.min.js"></script>

    <link rel="shortcut icon" href="/favicon.ico" type="image/vnd.microsoft.icon"/>
    <link rel="stylesheet" href="css/jq.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/prettify.css" rel="stylesheet">
    <script src="js/prettify.js"></script>

    <!-- Tablesorter: required for bootstrap -->
    <link rel="stylesheet" href="css/theme.bootstrap.css">
    <script src="js/jquery.tablesorter.js"></script>
    <script src="js/jquery.tablesorter.widgets.js"></script>

    <!-- Tablesorter: optional -->
    <link rel="stylesheet" href="css/jquery.tablesorter.pager.css">
    <script src="js/jquery.tablesorter.pager.js"></script>

    <!-- Custom js for the table. -->
    <script src="js/akamai-custom.js"></script>

  </head>
  <body>
    <div id="main">
      <h1>Hello, Akamai!</h1>
      <div class="bootstrap_buttons"><button type="button" class="reset btn btn-primary" data-column="0" data-filter=""><i class="icon-white icon-refresh glyphicon glyphicon-refresh"></i> Reset filters</button>
      </div>
      <div id="akamai-finder">
        <?php require_once './akamai-finder.php'; ?>
        <?php print akamai_finder_table(); ?>
      </div>
    </div>
  </body>
</html>
