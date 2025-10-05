<?php get_header(); ?>

	<main role="main" class="poll-page content">
		<div class="container-fluid">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a
						href="/"><?php _e('Головна', 'mz'); ?></a>
				</li>
				<li class="breadcrumb-item"><span><?php _e('Наша компанія орієнтована на постійне вдосконалення якості обслуговування клієнтів. Ми дуже цінуємо думку наших клієнтів і будемо  вдячні за Ваш відгук.', 'mz'); ?></span></li>
			</ol>
			<h1><?php _e('Наша компанія орієнтована на постійне вдосконалення якості обслуговування клієнтів. Ми дуже цінуємо думку наших клієнтів і будемо  вдячні за Ваш відгук.', 'mz'); ?></h1>
			<div class="questions">

				<div class="poll-send-interactive-first-load" style="text-align: center">
					<span class="error-msg" style="font-size: 20px;"></span>
					<div class="indicator preloader-poll-send" style="display: block">
						<svg width="32px" height="24px">
							<polyline id="back" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>
							<polyline id="front" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>
						</svg>
					</div>
				</div>

				<form method="POST" id="js-poll-send-form" style="display: none">

					<div class="questions-wrap"></div>

					<div class="poll-send-interactive">
						<span class="error-msg"></span>
						<div class="indicator preloader-poll-send">
							<svg width="32px" height="24px">
								<polyline id="back" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>
								<polyline id="front" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>
							</svg>
						</div>
					</div>

					<div class="questions-buttons">
						<button type="reset" class="btn btn-cancel"><?php _e('Очистити форму', 'mz'); ?></button>
						<button type="submit" class="btn" id="js-poll-send-button"><?php _e('Відправити', 'mz'); ?></button>
					</div>
				</form>
			</div>
		</div>
	</main>

<?php get_footer(); ?>