<?php namespace Barrot\Laratchet\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class LaRatchetServer extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'laratchet:serve';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Start the laratchet push server';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $this->info('Running Laratchet Push Server @ '.\Config::get('laratchet.pushServer').':'.\Config::get('laratchet.pushServerPort'));
		$server = new \Barrot\Laratchet\Server\LaratchetServer();
        $server -> serve();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [

		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [

		];
	}

}
