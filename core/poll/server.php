<?php

class Poll_Server
{
	public static function init()
	{
		add_action('wp_ajax_get_poll_data_by_id', [__CLASS__, 'getPollDataById']);
		add_action('wp_ajax_nopriv_get_poll_data_by_id', [__CLASS__, 'getPollDataById']);

		add_action('wp_ajax_send_poll_data', [__CLASS__, 'sendPollData']);
		add_action('wp_ajax_nopriv_send_poll_data', [__CLASS__, 'sendPollData']);
	}

	public static function validation($path, $poll_id, $data, $path2)
	{
//		$poll_data = $_SESSION['poll_data'];
		$poll_data = self::do_request($path, $poll_id, $path2);
		$errors = [];

		foreach ($poll_data['list'] as $item) {
			if (!array_key_exists($item['id'], $data)) {
				$errors[$item['id']] = $item['questionType'] == 'multiselect'
					? __('Виберіть один або більше пунктів')
					: __('Виберіть одну з відповідей');
			}

			if (in_array('custom', $data[$item['id']])
			    && empty($data[$item['id'] . '-custom'])
			) {
				$errors[$item['id']] = __('Заповніть свій варіант');
			}
		}

		return $errors;
	}

	/*
	 * Array
		(
		    [pathname] => /p/65f855c03b4930022/
		    [action] => get_poll_data_by_id
		)
	 * */
	public static function getPollDataById()
	{
        $path = $_POST['pathname'];
        $poll_id = '';
        $is_360 = false;
        
        if (strpos($path, '/p/') !== false) {
            $poll_id = trim(str_replace('/p/', '', $path), '/');
        } elseif (strpos($path, '/o/') !== false) {
            $is_360 = true;
            $poll_id = trim(str_replace('/o/', '', $path), '/');
        }

        if (isset($is_360) && $is_360){
            $sentSurveys360 = self::do_request('SentSurveys360', $poll_id);
            $response = self::do_request('QuestionsSurveys360', '', '', 'asc');
            $data = self::parse_response360($response);
            $title = $sentSurveys360['surveys360Name'];
        } else {
            self::do_request('SentSurveys', $poll_id);
            $response = self::do_request('SentSurveys', $poll_id, '/questionsSurveyses?orderBy=priority');
            $data = self::parse_response($response);
            $title = 'Наша компанія орієнтована на постійне вдосконалення якості обслуговування клієнтів. Ми дуже цінуємо думку наших клієнтів і будемо вдячні за Ваш відгук.';
        }

        $result = array(
            'data' => $data,
            'title' => $title
        );

		wp_send_json_success($result);
	}

	/*
	 * Array
			(
			    [radio1] => Array
			        (
			            [0] => value4
			            [1] => 324 //custom
			        )

			    [checkbox1] => Array
			        (
			            [0] => value2
			            [1] => value3
			            [2] => value4
			            [3] => ertter //custom
			        )

			    [comment] =>
			    [action] => send_poll_data
			)
	 * */
	public static function sendPollData()
	{
		$data = $_POST;
        if (strpos($_POST['pathname'], '/p/') !== false) {
            $poll_id = trim(str_replace('/p/', '', $_POST['pathname']), '/');
            $path = 'SentSurveys';
            $path2 = '/questionsSurveyses';
            $pathValidation = 'SentSurveys';
            $poll_id_validation = $poll_id;
        } elseif (strpos($_POST['pathname'], '/o/') !== false) {
            $poll_id = trim(str_replace('/o/', '', $_POST['pathname']), '/');
            $path = 'SentSurveys360';
            $path2 = '';
            $pathValidation = 'QuestionsSurveys360';
            $poll_id_validation = '';
        }


		unset($data['action']);
		unset($data['pathname']);
		$errors = self::validation($pathValidation, $poll_id_validation, $data, $path2);

		if (!empty($errors)) {
			wp_send_json_error([
				'code'   => 'validation_error',
				'errors' => $errors,
			]);
		}

		$response_data = self::do_request($path, $poll_id, $path2);

		$response = [];
		$responsesText = '';

		foreach ($data as $key => $item) {
			if (strpos($key, '-custom') !== false) continue;
			if (strpos($key, '-comment') !== false) continue;

			$response_custom = '';
			if (in_array('custom', $item)) {
				$response_custom = $data[$key . '-custom'];
//				$response_custom = ',' . $data[$key . '-custom'];
				$custom_key = array_search('custom', $item);
				unset($item[$custom_key]);
			}

			$comment = !empty($data[$key . '-comment']) ? $data[$key . '-comment'] : '';

//			$responses = implode(',', $item);

			if ($response_custom) {
				$item[] = $response_custom;
			}

			$response[] = json_encode([
				"id"       => $key,
				"responce" => $item,
				"comment"  => $comment,
			], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);
		}

		foreach ($response as $k => $response_item) {
			$response_name = array_filter($response_data['list'], static function ($k) use ($response_item) {
				$response_item_decode = json_decode($response_item);
				return $k['id'] == $response_item_decode->id;
			});
			$name = current($response_name)['question'];
			$data = json_decode($response_item);
			$responce = is_object($data->responce) ? (array)$data->responce : $data->responce;
			$responsesText .= ($k + 1) . '. ' . $name . ' => ' . implode(',', $responce);
			if ($data->comment) $responsesText .= ' => ' . $data->comment;
			$responsesText .= "\n\r";
		}
		$response_send = [
			"isGetResponce"    => true,
			"responceDateTime" => date('Y-m-d H:i:s'),
			"responsesArray"   => json_encode($response, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE),
			"responsesText"    => $responsesText,
		];

//		$poll_id = $_SESSION['poll_id'];

		$ch = curl_init();
		$url = API_URL_CRM . '/' . $path . '/' . $poll_id;

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response_send, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE));
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "X-Api-Key: ".API_X_API_KEY_CRM,
			"Content-Type: application/json",
			//	"Content-Length: " . strlen(json_encode($response_send)),
		]);

		json_decode(curl_exec($ch), true);

		$curl_error = null;
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
			$curl_error = ['message' => __('Server error!', 'mz')];
		}
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 401) {
			$curl_error = ['message' => __('Access Denied!', 'mz')];
		}

		curl_close($ch);

		if ($curl_error) {
			wp_send_json_error($curl_error);
		}

		Poll_Db::savePollData($poll_id, $response_send['responceDateTime'], $response_send['responsesArray']);
//		unset($_SESSION['poll_id']);
//		unset($_SESSION['poll_data']);

		wp_send_json_success([
			'message' => '<div class="title-sm text-center">'
			             . __('Дякуємо за ваші відповіді!', 'mz')
			             . '</div>',
		]);
	}

	public static function parse_response($response)
	{
		$data = '';

		foreach ($response['list'] as $question) {
			$data .= '<div class="question" id="' . $question['id'] . '">';
			$data .= '<div class="question-title">' . trim($question['question']) . '</div>';

			foreach ($question['responses'] as $option) {
				if ($question['questionType'] == 'select') {
					$data .= '<label><input name="' . $question['id'] . '[]" type="radio" value="' . trim($option) . '"/>' . trim($option) . '</label>';
				}
				if ($question['questionType'] == 'multiselect') {
					$data .= '<label><input name="' . $question['id'] . '[]" type="checkbox" value="' . trim($option) . '"/>' . trim($option) . '</label>';
				}
			}

			if ($question['customOption'] && $question['questionType'] == 'select') {
				$data .= '<div class="question-option-custom">
								<label><input name="' . $question['id'] . '[]" type="radio" value="custom"/>' . __('Інший варіант', 'mz') . '</label><input type="text" name="' . $question['id'] . '-custom"/>
							</div>';
			}

			if ($question['customOption'] && $question['questionType'] == 'multiselect') {
				$data .= '<div class="question-option-custom">
								<label><input name="' . $question['id'] . '[]" type="checkbox" value="custom"/>' . __('Інший варіант', 'mz') . '</label><input type="text" name="' . $question['id'] . '-custom"/>
							</div>';
			}

			if ($question['comment']) {
				$data .= '<div class="questions-comment">
								<textarea name="' . $question['id'] . '-comment" placeholder="' . __('Залишити коментар', 'mz') . '"></textarea>
							</div>';
			}

			$data .= '</div>';
		}

		$data .= '';

		return $data;
	}

	public static function parse_response360($response)
	{
		$data = '';

		foreach ($response['list'] as $question) {
			$data .= '<div class="question" id="' . $question['id'] . '">';
			$data .= '<div class="question-title">' . trim($question['name']) . '</div>';

			foreach ($question['responses'] as $option) {
                $data .= '<label><input name="' . $question['id'] . '[]" type="radio" value="' . trim($option) . '"/>' . trim($option) . '</label>';
			}

			$data .= '</div>';
		}

		$data .= '';

		return $data;
	}

	public static function do_request($path, $poll_id = '', $path2 = '', $order = '')
	{
//		$_SESSION['poll_data'] = null;
//		$_SESSION['poll_id'] = null;
		$ch = curl_init();
        if($poll_id){
		    $url = API_URL_CRM . '/' . $path . '/' . $poll_id . $path2;
        } else {
		    $url = API_URL_CRM . '/' . $path;
        }

        if($order){
            $url .= '?order=' . $order;
        }

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"X-Api-Key: ".API_X_API_KEY_CRM,
		]);

		$response = json_decode(curl_exec($ch), true);

		$curl_error = null;
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
			$curl_error = ['message' => __('Server error!', 'mz')];
		}
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 401) {
			$curl_error = ['message' => __('Access Denied!', 'mz')];
		}
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 404) {
			$curl_error = ['code' => 404, 'message' => __('Такого опитування не існує', 'mz')];
		}

		curl_close($ch);

		if ($curl_error) {
			wp_send_json_error($curl_error);
		}

		if (!empty($response['finalTime']) && strtotime($response['finalTime']) < time() && empty($path2)) {
			wp_send_json_error(['message' => __('Це питання більше не актуальне', 'mz')]);
		}

		//@todo == 1
		if ($response['isGetResponce'] == 1 && empty($path2)) {
			wp_send_json_error(['message' => __('На це питання вже дали відповідь', 'mz')]);
		}

//		if (!empty($path2)) {
//			$_SESSION['poll_data'] = $response;
//			$_SESSION['poll_id'] = $poll_id;
//		}

		return $response;
	}
}

Poll_Server::init();