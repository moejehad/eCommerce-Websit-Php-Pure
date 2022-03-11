<section class="footer">
    <div class="container">
    
        <div class="row">
                <div class="col-sm-4">
                    <h3>Yellow Store</h3>
                    <ul class="list-links">
                        <li><a href="about.php">نبذة عنا</a></li>
                        <li><a href="protect.php">ضمان حقوقك</a></li>
                        <li><a href="terms.php">شروط الاستخدام</a></li>
                        <li><a href="privacy.php">سياسة الخصوصية</a></li>
                        <li><a href="contact.php">اتصل بنا</a></li>
                    </ul>
                </div>
            
                <div class="col-sm-4">
                    <h3>الأقسام</h3>
                    <ul class="list-links">
                           
                        <?php 
          
                          $categorise = getCat();

                            foreach ($categorise as $cat){

                            if($cat['parent'] < 1){

                             echo '<li><a href="categories.php?pageid=' . $cat['ID'] .  '&name=' .str_replace(' ','-',$cat['Name']) .  ' ">' . $cat['Name'] . '</a></li>';

                            }
                                }

                          ?>  
                        
                    </ul>
                </div>
            
                <div class="col-sm-4">
                    
                         <div class="col-sm-12">
                            <h3>وسائل الدفع المتاحة</h3>
                            <ul class="list-meta">
                                <li><i class="pay fa fa-credit-card"></i> <span>المحفظة</span>
                                </li>
                                <li><i class="pay fa fa-lg fa-truck"></i> <span>عند الإستلام</span>
                                </li>
                            </ul>
                        </div>
            
                    <div class="col-sm-12">
                            <h3>تابع Yellow Store على</h3>
                            <ul class="list-meta mrg--bl">
                                
                                <li><a href="#" class="btn btn-facebook" target="_blank"><i class="fa fa-fw fa-facebook"></i> <span class="sr-only">Facebook</span></a>
                                </li>
                                
                                <li><a href="#" class="btn btn-twitter" target="_blank"><i class="fa fa-fw fa-twitter"></i> <span class="sr-only">Twitter</span></a></li>
                                
                                <li><a href="#" class="btn btn-instagram" target="_blank"><i class="fa fa-fw fa-instagram"></i> <span class="sr-only">Twitter</span></a></li>
                                
                            </ul>
                        </div>
                    
                </div>
                        
            </div>
        
    </div>
    
            <div class="footer__rights">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted">
                            <small> جميع الحقوق محفوظة لــ Yellow Store © 2019 .</small>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-left" dir="ltr">
                            <small>© 2019 yelsto.com . All rights reserved.</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="<?php echo $js;?>script.js"></script>
        <script src="<?php echo $js;?>bootstrap.min.js"></script>
        <script src="<?php echo $js;?>bootstrap.js"></script>

    
</section>

</body>
</html>