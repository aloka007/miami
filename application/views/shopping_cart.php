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
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css" >
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/mobile.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
        <script type="text/javascript" src="<?php echo base_url(); ?>js/mobile.js" ></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js" ></script>
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
                    <h3>Shopping Cart</h3>

                    <div id="shopping-cart">
                        <div class="header">

                            <div class="pull-right">

                                <a href="/miami/index.php" class="btn btn-success"><span class="glyphicon glyphicon-arrow-left"></span> Back to Shopping</a>
                                <a href="/miami/index.php" class="btn btn-warning"> Checkout <span class="glyphicon glyphicon-ok"></span></a>
                                <a href="?action=empty" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Empty Cart</a>
                            </div>

                        </div>
                        <?php
                        if (isset($_SESSION["cart_item"])) {
                            $item_total = 0;
                            ?>	
                            <table class="table table-striped" cellpadding="10" cellspacing="1">
                                <tbody>
                                    <tr>
                                        <th><strong>Name</strong></th>
                                        <th><strong>Code</strong></th>
                                        <th><strong>Quantity</strong></th>
                                        <th><strong>Price</strong></th>
                                        <th><strong>Action</strong></th>
                                    </tr>	
                                    <?php
                                    foreach ($_SESSION["cart_item"] as $item) {
                                        ?>
                                        <tr>
                                            <td><strong><?php echo $item["name"]; ?></strong></td>
                                            <td><?php echo $item["code"]; ?></td>
                                            <td><?php echo $item["quantity"]; ?></td>
                                            <td align=left><?php echo " " . $item["price"]." LKR"; ?></td>
                                            <td><a href="?action=remove&code=<?php echo $item["code"]; ?>" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span>Remove Item</a></td>
                                        </tr>
                                        <?php
                                        $item_total += ($item["price"] * $item["quantity"]);
                                    }
                                    ?>

                                    <tr>
                                        <td colspan="5" align=right><big><strong>Total:</strong> <span class="badge"><?php echo " " . $item_total." LKR"; ?> </span></big></td>
                                    </tr>
                                </tbody>
                            </table>		
                            <?php
                        }
                        ?>
                    </div>


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
