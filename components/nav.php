<?php
$current = basename($_SERVER['PHP_SELF']);
?>

<div class="header">

    <div class="logo">
        <a href="index.php">
            <img src="https://www.legaisee.com/Images/Legaisee-sm-300.png">
        </a>
    </div>

    <div class="nav">

        <a href="index.php" 
           class="<?php echo $current == 'index.php' ? 'active' : ''; ?>">
           Dashboard
        </a>

        <a href="search.php"
           class="<?php echo $current == 'search.php' ? 'active' : ''; ?>">
           Search
        </a>

        <a href="ingest.php"
           class="<?php echo $current == 'ingest.php' ? 'active' : ''; ?>">
           Ingest
        </a>

        <a href="files.php"
           class="<?php echo $current == 'files.php' ? 'active' : ''; ?>">
           Files
        </a>

    </div>

</div>