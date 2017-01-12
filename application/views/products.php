<!doctype html>
<!-- Website template by freewebsitetemplates.com -->
<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            if (!empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM product WHERE code='" . $_GET["code"] . "'");
                $itemArray = array($productByCode[0]["code"] => array('name' => $productByCode[0]["name"], 'code' => $productByCode[0]["code"], 'quantity' => $_POST["quantity"], 'price' => $productByCode[0]["price"]));

                if (!empty($_SESSION["cart_item"])) {
                    if (in_array($productByCode[0]["code"], $_SESSION["cart_item"])) {
                        foreach ($_SESSION["cart_item"] as $k => $v) {
                            if ($productByCode[0]["code"] == $k)
                                $_SESSION["cart_item"][$k]["quantity"] = $_POST["quantity"];
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
            break;
        case "remove":
            if (!empty($_SESSION["cart_item"])) {
                foreach ($_SESSION["cart_item"] as $k => $v) {
                    if ($_GET["code"] == $k)
                        unset($_SESSION["cart_item"][$k]);
                    if (empty($_SESSION["cart_item"]))
                        unset($_SESSION["cart_item"]);
                }
            }
            break;
        case "empty":
            unset($_SESSION["cart_item"]);
            break;
    }
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIAMI Graphic Designs</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/mobile.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="<?php echo base_url(); ?>js/mobile.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div id="page">
    <div id="header">
        <div id="navigation">
            <span id="mobile-navigation">&nbsp;</span>
            <a href="index.html" class="logo"><img src="<?php echo base_url(); ?>images/logo.png" alt=""></a>
            <ul id="menu">
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li>
                    <a href="about.html">About</a>
                </li>
                <li class="selected">
                    <a href="running.html">Products</a>
                    <ul>
                        <li>
                            <a href="runningsinglepost.html">Running single post</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="blog.html">Blog</a>
                    <ul>
                        <li>
                            <a href="blogsinglepost.html">blog single post</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="contact.html">Contact</a>
                </li>
            </ul>
        </div>
    </div>
    <div id="body">
        <div>
            <h1>Premade Products</h1>


            <?php
            if (isset($_SESSION["cart_item"])) {
                $item_total = 0;
                ?>
                <div id="shopping-cart">
                    <div class="pull-right">
                        <a href="/miami/index.php/Cart" class="btn btn-success"><span class="glyphicon glyphicon-shopping-cart"></span> View Cart  <span class="badge"><?php echo sizeof($_SESSION["cart_item"]); ?></span></a>
                        <a href="?action=empty" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Empty Cart</a>

                    </div>
                </div>
                <?php
            }
            ?>


            <div id="product-grid" class="product-grid">
                <!--                        <div class="txt-heading">Products</div>-->
                <?php
                $product_array = $db_handle->runQuery("SELECT * FROM product ORDER BY id ASC");
                if (!empty($product_array)) {
                    foreach ($product_array as $key => $value) {
                        ?>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <form method="post"
                                  action="?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                <div class="product-image"><img class="i-image"
                                                                src="<?php echo base_url(); ?><?php echo $product_array[$key]["image"]; ?>">
                                </div>
                                <div class="product-name">
                                    <strong><?php echo $product_array[$key]["name"]; ?></strong>
                                </div>
                                <div>
                                    class="product-price"><?php echo $product_array[$key]["price"] . " LKR"; ?>
                                </div>
                                <div><input class="form-control" type="number" name="quantity" value="1" size="2"/>
                                </div>
                                <div><input type="submit" value="Add to cart" class="btnAddAction"/></div>
                            </form>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <h1><br>Customize your own</h1>

            <h3><span>What’s more, they’re absolutely free! You can do a lot with them. You can modify them.</span>
            </h3>

            <p>Our website templates are created with inspiration, checked for quality and originality and
                meticulously
                sliced and coded. What’s more, they’re absolutely free! You can do a lot with them. You can modify
                them.
                You can use them to design websites for clients, so long as you agree with the Terms of Use. You can
                even remove all our links if you want to. Looking for more templates? Just browse through all our
                Free
                Website Templates and find what you’re looking for.</p>

            <p>But if you don’t find any website template you can use, you can try our Free Web Design service and
                tell
                us all about it. Maybe you’re looking for something different, something special. And we love the
                challenge of doing something different and something special. If you’re experiencing issues and
                concerns
                about this website template, join the discussion on our forum and meet other people in the community
                who
                share the same interests with you.</p>
        </div>
    </div>
    <div id="footer">
        <div>
            <div class="connect">
                <a href="http://freewebsitetemplates.com/go/twitter/" class="twitter">twitter</a>
                <a href="http://freewebsitetemplates.com/go/facebook/" class="facebook">facebook</a>
                <a href="http://freewebsitetemplates.com/go/googleplus/" class="googleplus">googleplus</a>
                <a href="http://pinterest.com/fwtemplates/" class="pinterest">pinterest</a>
            </div>
            <p>&copy; 2023 by RNRNR. All rights reserved.</p>
        </div>
    </div>
</div>
</body>
</html>
