<?php

namespace Qpdb\SlimApplication\Controllers;


use Firebase\JWT\JWT;
use Qpdb\SlimApplication\Config\ConfigService;
use Slim\Exception\NotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;

class CategoriesController
{
	/**
	 * @var ConfigService
	 */
	private $configService;

	/**
	 * CategoriesController constructor.
	 * @param ConfigService $configService
	 * @internal param DbService $dbService
	 */
	public function __construct()
	{
		//$this->configService = $configService;
	}


	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 * @return Response
	 * @throws \Slim\Exception\NotFoundException
	 */
	public function indexAction( Request $request, Response $response, array $args ) {

		$name = $args['name'];
		$page = isset($args['page']) ? $args['page'] : 1;

		$otherParams = $request->getParam('filter');

		$postParams = $request->getParsedBodyParam('postVar');

		$testVar = $request->getAttributes();

		var_dump($request->getParsedBody());


		if($name == 'aragaz'){
			//$response = new Response();
			throw new NotFoundException($request, $response);
        }

        var_dump($request->getHeaderLine('Authorization'));
		var_dump($request->getHeaderLine('Accept'));


		if($name == 'admin')
			return $response->withRedirect('/categs/login/',301);


		echo "<pre>" . print_r($request->getUri()->getPath(),1) . "</pre>";
		echo "<pre>" . print_r($request->getParams(),1) . "</pre>";

		var_dump($args);

		$response->getBody()->write($name . ' write method');
		$response->write($page);

//		$response = $response
//            ->withStatus(404);

		return $response;

	}

	public function login( Request $request, Response $response, array $args )
    {
        var_dump($args);
        return $response;
    }

	public function contact( Request $request, Response $response, array $args )
    {
        return $response->getBody()->write('contact route');
    }

	public function formAction( Request $request, Response $response, array $args )
	{
		$postParams = $request->getParams();

		$test = [
			'user' => 'adrian@gmail.com',
			'pass' => 'parola',
			//'expire' => time()
		];

		$jwt = JWT::encode($test, 'hg0059', 'HS256');
		$decoded = (array)JWT::decode($jwt, 'hg005944', array('HS256'));

		$response->write( $this->formConstruct() . print_r($decoded, 1) );
		return $response;
	}

	private function formConstruct()
	{
		ob_start();
		?>
		<form method="post">
			<input type="text" name="nume">
			<input type="submit" name="sub" value="button">
		</form>
		<?php

		$htm = ob_get_contents();
		ob_clean();

		return str_replace('bla', 'haha', $htm ) . ' from buffer';
	}

}