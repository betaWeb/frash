<?php
namespace Frash\Framework\Controller;
use Frash\Framework\DIC\Dic;

/**
 * Class BaseController
 * @package Frash\Framework\Controller
 */
class BaseController{
	/**
	 * @var Dic
	 */
	protected $dic;

	/**
	 * @var object
	 */
	protected $form;

	/**
	 * @var object
	 */
	protected $orm;

	/**
	 * @var object
	 */
	protected $redirect;

	/**
	 * @var object
	 */
	protected $session;

	/**
	 * @var object
	 */
	protected $tpl;

    /**
     * BaseController constructor.
     * @param Dic $dic
     */
	public function __construct(Dic $dic){
		$this->dic = $dic;
		$this->orm = $this->dic->load('orm');
		$this->redirect = $this->dic->load('redirect');
		$this->session = $this->dic->load('session');
		$this->tpl = $this->dic->load('tpl');

		$form = $this->dic->load('form');
		$this->form = (object) [
			'create' => $form->create(),
			'createSql' => $form->createSql(),
			'verif' => $form->verif(),
			'post' => $form->getPost()
		];
	}
}