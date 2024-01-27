<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title><?=$pgTitle?></title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    
    <?php
        //Call to a view directly in this case the view is menu
        echo $this->include('plantilla/menu');
    ?>

    <?php echo $this->renderSection('contenido'); ?>
    
    <footer>
        <p><?=$pgFooter;?></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
    
    <?php echo $this->renderSection('jsCode'); ?>
</body>

</html>