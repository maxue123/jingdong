<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
?>
<!-- ============================================================= HEADER : END ============================================================= -->		<!-- ========================================= MAIN ========================================= -->
<main id="authentication" class="inner-bottom-md">
	<div class="container">
		<div class="row">
			
			<div class="col-md-6">
				<section class="section sign-in inner-right-xs">
					<h2 class="bordered">登录</h2>
					<p>您好，欢迎使用您的帐户</p>

					<div class="social-auth-buttons">
						<div class="row">
							<div class="col-md-6">
								<button class="btn-block btn-lg btn btn-facebook"><i class="fa fa-facebook"></i> Sign In with Facebook</button>
							</div>
							<div class="col-md-6">
								<button class="btn-block btn-lg btn btn-twitter"><i class="fa fa-twitter"></i> Sign In with Twitter</button>
							</div>
						</div>
					</div>
					<?php
					    $form = ActiveForm::begin([
					        'options' => ['class' => 'login-form cf-style-1','role' => 'form',],
					        'fieldConfig' => [
					            'template' => '<div class="field-row">{label}{input}</div>{error}'
					        ],
					    ]);
					?>
					<?php echo $form->field($model, 'loginname')->textInput(['class' => 'le-input']); ?>
					<?php echo $form->field($model, 'userpass')->passwordInput(['class' => 'le-input']); ?>
					<div class="field-row clearfix">
	                    <?php echo $form->field($model, 'rememberMe')->checkbox([
	                        'template' => '<span class="pull-left"><label class="content-color">{input} <span class="bold">记住我</span></label></span>',
	                        'class' => "le-checkbox auto-width inline",
	                    ]); ?>
                    	<span class="pull-right">
                    		<a href="#" class="content-color bold">忘记密码 ?</a>
                    	</span>
                    </div>
					<?php echo Html::submitButton('登录',["class"=>"le-button huge"]);?>
					<?php $form = ActiveForm::end(); ?>
				</section><!-- /.sign-in -->
			</div><!-- /.col -->

			<div class="col-md-6">
				<section class="section register inner-left-xs">
					<h2 class="bordered">建立新帐户</h2>
					<p>创建您自己的Media Center帐户</p>
					<?php
					    if (Yii::$app->session->hasFlash('info')) {
					        echo Yii::$app->session->getFlash('info');
					    }
					    $form = ActiveForm::begin([
					        'options' => ['class' => 'register-form cf-style-1','role' => 'form',],
					        'fieldConfig' => [
					            'template' => '<div class="field-row">{label}{input}</div>{error}'
					        ],
					        'action' => ['member/reg'],
					    ]);
					?>
					<?php echo $form->field($model, 'useremail')->textInput(['class' => 'le-input']); ?>
					<div class="buttons-holder">
					    <?php echo Html::submitButton('注册', ['class' => 'le-button huge']); ?>
					</div>
					<?php ActiveForm::end(); ?>
					
					<h2 class="semi-bold">今天注册并且您将能够：</h2>

					<ul class="list-unstyled list-benefits">
						<li><i class="fa fa-check primary-color"></i> 加快结账速度</li>
						<li><i class="fa fa-check primary-color"></i> 轻松跟踪您的订单</li>
						<li><i class="fa fa-check primary-color"></i> 记录您的所有购买情况</li>
					</ul>

				</section><!-- /.register -->

			</div><!-- /.col -->

		</div><!-- /.row -->
	</div><!-- /.container -->
</main><!-- /.authentication -->
<!-- ========================================= MAIN : END ========================================= -->		