<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Accueil</a></li>
                <li class="active">panier</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <?php

            // if (!isset($_SESSION['USERID'])){
            //     redirect("index.php");
            check_message();

            ?>

            <table  class="table table-condensed" id="table" >
                <thead>
                <tr class="cart_menu">
                    <td  >Produit</td>
                    <td >Description</td>
                    <td  width="15%" >Prix</td>
                    <td  width="15%" >Quantite</td>
                    <td  width="15%" >Total</td>
                </tr>
                </thead>

                <?php
                if (!empty($_SESSION['gcCart'])){

                    echo '<script>totalprice()</script>';

                    $count_cart = count($_SESSION['gcCart']);

                    for ($i=0; $i < $count_cart  ; $i++) {

                        $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
                                                 WHERE pr.`PROID`=p.`PROID` AND  p.`CATEGID` = c.`CATEGID`  and p.`PROID` = '".@$_SESSION['gcCart'][$i]['productid']."'";
                        $mydb->setQuery($query);
                        $cur = $mydb->loadResultList();


                        foreach ($cur as $result) {

                            ?>
                            <tr>
                                <td>
                                    <img src="<?php echo web_root. 'admin/products/'.$result->IMAGES; ?>"  onload="  totalprice() " width="50px" height="50px">
                                    <br/>
                                    <?php


                                    if (isset($_SESSION['CUSID'])){

                                        echo ' <a href="'.web_root. 'customer/controller.php?action=addwish&proid='.$result->PROID.'" title="Ajouter au favoris">Ajouter au favoris</a>';

                                    }else{
                                        echo   '<a href="#" title="Ajouter au favoris" class="proid"  data-target="#smyModal" data-toggle="modal" data-id="'.  $result->PROID.'">Ajouter au favoris</a>
             ';
                                    }




                                    ?>




                                </td>
                                <td>
                                    <?php echo  $result->PRODESC ; ?>
                                </td>
                                <td>
                                    <input type="hidden"    id ="PROPRICE<?php echo $result->PROID;  ?>" name="PROPRICE<?php echo $result->PROID; ?>" value="<?php echo  $result->PRODISPRICE ; ?>" >

                                    <?php echo  $result->PRODISPRICE ; ?> FCFA
                                </td>
                                <td class="input-group custom-search-form" >
                                    <input type="hidden" maxlength="3" class="form-control input-sm"  autocomplete="off"  id ="ORIGQTY<?php echo $result->PROID;  ?>" name="ORIGQTY<?php echo $result->PROID; ?>" value="<?php echo $result->PROQTY; ?>"   placeholder="Search for...">

                                    <input type="number" maxlength="3" data-id="<?php echo $result->PROID;  ?>" class="QTY form-control input-sm"  autocomplete="off"  id ="QTY<?php echo $result->PROID;  ?>" name="QTY<?php echo $result->PROID; ?>" value="<?php echo $_SESSION['gcCart'][$i]['qty']; ?>"   placeholder="Search for...">
                                    <span class="input-group-btn">
                                                <a title="Remove Item"  class="btn btn-danger btn-sm" id="btnsearch" name="btnsearch" href="cart/controller.php?action=delete&id=<?php echo $result->PROID; ?>">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </span>
                                </td>

                                <input type="hidden"    id ="TOT<?php echo $result->PROID;  ?>" name="TOT<?php echo $result->PROID; ?>" value="<?php echo  $result->PRODISPRICE ; ?>" >

                                <td> <output id="Osubtot<?php echo $result->PROID ?>"><?php echo   $_SESSION['gcCart'][$i]['price'] ; ?></output> FCFA</td>
                            </tr>

                            <?php
                        }
                    }
                }else{
                    echo "<h1>Il n'y a aucun produit dans le panier.</h1>";
                }
                ?>

            </table>


            <h3 align="right"> Total  <span id="sum">0</span> FCFA</h3>
        </div>
    </div>
</section>
<section id="do_action">
    <div class="container">
        <div class="heading">
            <h3>What would you like to do next?</h3>
            <p>Choisissez si vous avez un code de reductionou des points de recompense que vous souhaitez utiliser, ou si vous souhaitez estimer votre cout de livraison.</p>
        </div>
        <div class="row">
            <form action="index.php?q=orderdetails" method="post">
                <a href="index.php?q=product" class="btn btn-default check_out pull-left ">
                    <i class="fa fa-arrow-left fa-fw"></i>
                    Ajouter une nouvelle commande
                </a>

                <?php

                $countcart =isset($_SESSION['gcCart'])? count($_SESSION['gcCart']) : "0";
                if ($countcart > 0){

                    if (isset($_SESSION['CUSID'])){

                        echo '<button type="submit"  name="proceed" id="proceed" class="btn btn-default check_out btn-pup pull-right">
                            Proceder et commander
                            <i class="fa  fa-arrow-right fa-fw"></i>
                            </button>';

                    }else{
                        echo   '<a data-target="#smyModal" data-toggle="modal" class="btn btn-default check_out signup pull-right" href="">
                              Proceder et commander
                              <i class="fa  fa-arrow-right fa-fw"></i>
                              </a>';
                    }
                }



                ?>
            </form>
        </div>
    </div>
</section><!--/#do_action-->