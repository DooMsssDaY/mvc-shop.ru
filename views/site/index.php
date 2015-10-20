<?php include ROOT.'/views/layouts/header.php';?>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="left-sidebar">
                            <h2>Каталог</h2>
                            <div class="panel-group category-products">
                                
                                <?php foreach ($categories as $categoryItem): ?>
                                    
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a href="/category/<?php echo $categoryItem['id']; ?>">
                                                    <?php echo $categoryItem['name']; ?>
                                                </a>
                                            </h4>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-9 padding-right">
                        <div class="features_items"><!--features_items-->
                            <h2 class="title text-center">Последние товары</h2>
                                
                                <?php foreach ($latestProd as $prodItem): ?>
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">
                                                    <img src="<?php echo Product::getImageProduct($prodItem['id']); ?>" alt="" style='max-height:150px;'/>
                                                    <h2><?php echo $prodItem['price'];?>$</h2>
                                                    <p><a href="/product/<?php echo $prodItem['id'];?>"><?php echo $prodItem['name'];?></a></p>
                                                    <a href="javascript:void(0);" product-id='<?php echo $prodItem['id'];?>' class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>В корзину</a>
                                                </div>
                                                <?php if($prodItem['is_new']):?>
                                                    <img src='/template/images/home/new.png' class='new' alt=''/>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                        </div><!--features_items-->

                        <div class="recommended_items"><!--recommended_items-->
                            <h2 class="title text-center">Рекомендуемые товары</h2>

                            <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">	
                                    <div class="item active">

                                        <?php 
                                            $i=1;
                                            foreach ($recommendedProducts as $recommendedProduct): ?>
                                            <div class="col-sm-4">
                                                <div class="product-image-wrapper">
                                                    <div class="single-products">
                                                        <div class="productinfo text-center">
                                                            <img src="<?php echo Product::getImageProduct($recommendedProduct['id']); ?>" alt="" style='max-height:150px;'/>
                                                            <h2>$<?php echo $recommendedProduct['price'];?></h2>
                                                            <p><a href="/product/<?php echo $recommendedProduct['id'];?>"><?php echo $recommendedProduct['name'];?></a></p>
                                                            <a href="javascript:void(0);" product-id='<?php echo $recommendedProduct['id'];?>' class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>В корзину</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        unset($recommendedProducts[0]);
                                        sort($recommendedProducts);
                                        if ($i == 3)
                                            break;
                                        $i++;
                                        endforeach;?>

                                    </div>
                                    <div class="item">  

                                        <?php foreach ($recommendedProducts as $recommendedProduct): ?>
                                            <div class="col-sm-4">
                                                <div class="product-image-wrapper">
                                                    <div class="single-products">
                                                        <div class="productinfo text-center">
                                                            <img src="<?php echo Product::getImageProduct($recommendedProduct['id']); ?>" alt="" style='max-height:150px;'/>
                                                            <h2>$<?php echo $recommendedProduct['price'];?></h2>
                                                            <p><a href="/product/<?php echo $recommendedProduct['id'];?>"><?php echo $recommendedProduct['name'];?></a></p>
                                                            <a href="javascript:void(0);" product-id='<?php echo $recommendedProduct['id'];?>' class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>В корзину</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                    </div>
                                </div>
                                <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                                    <i class="fa fa-angle-left"></i>
                                </a>
                                <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                                    <i class="fa fa-angle-right"></i>
                                </a>			
                            </div>
                        </div><!--/recommended_items-->

                    </div>
                </div>
            </div>
        </section>

<?php include ROOT.'/views/layouts/footer.php';?>