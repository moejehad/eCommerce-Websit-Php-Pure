<?php 

ob_start();

session_start();

$pageTitle = 'عن Yellow Store';

include "inti.php"; 

?>

<section class="about">
    <div class="container">
        
        <div class="col-md-12">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <h2>Yellow Store</h2>
                        <p>هي منصة فلسطينية الأولى من نوعها في مجال التجارة الإلكترونية نسعى من خلال خدماتنا لتقديم منصة كاملة لأصحاب المشاريع الصغيرة والمحلات
                    التجارية ومن لديهم منتجات غير قادرين على إيصالها للناس من خلال توفير المنصة خدمة بيع أعمالهم للمستخدمين بأمان أكثر سرعة ومرونة .</p>
                    </div>
            
                    <div class="col-md-12">
                        <h2>الشراء </h2>
                        <p>تستطيع أن تشتري ما تحتاج بكل سهولة بالسعر المعروض بالمتجر ولن يدفع المستخدم سوى سعر المنتج  .</p>
                    </div>

                    <div class="col-md-12">
                        <h2>البيع </h2>
                        <p>تستطيع عرض منتجاتك وبيعها في منصتنا من خلال تسجيلك كحساب بائع ودفع الاشتراك في اقرب نقطة دفع إليك .</p>
                    </div>
            </div>
            
            <div class="col-md-6">
                <img class="pull-left" src="layout/imgs/Untitled-5.png" />
            </div>
        </div>
    </div>
</section>


<?php 
    
    include $tpl . 'footer.php'; 
    ob_end_flush();
?>