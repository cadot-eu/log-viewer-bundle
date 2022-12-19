<?php

namespace Evotodi\LogViewerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

	public function getConfigTreeBuilder(): TreeBuilder
    {
		$treeBuilder = new TreeBuilder('evotodi_log_viewer');
		$rootNode = $treeBuilder->getRootNode();

		$rootNode->children()
			->arrayNode('log_files')
				->info('List of log files to show')
				->useAttributeAsKey('log_name')
				->arrayPrototype()
					->children()
						->scalarNode('path')->info("Use full path")->end()
						->scalarNode('name')->info("Pretty name to display else file name")->defaultNull()->end()
						->integerNode('days')->info('Number of days to pull from log. See ddtraceweb/monolog-parser.')->defaultValue(0)->end()
						->scalarNode('pattern')->info('See ddtraceweb/monolog-parser for patterns.')->defaultNull()->end()
						->scalarNode('date_format')->info('PHP style date format of log file')->defaultNull()->end()
                        ->booleanNode('use_channel')->defaultTrue()->info('Pattern has P<logger>')->end()
                        ->booleanNode('use_level')->defaultTrue()->info('Pattern has P<level>')->end()
						->arrayNode('levels')
							->info('Log level spelling. Case sensitive')
							->addDefaultsIfNotSet()
							->children()
								->scalarNode('debug')->info('Spelling for debug level')->defaultValue('DEBUG')->end()
								->scalarNode('info')->info('Spelling for info level')->defaultValue('INFO')->end()
								->scalarNode('notice')->info('Spelling for notice level')->defaultValue('NOTICE')->end()
								->scalarNode('warning')->info('Spelling for warning level')->defaultValue('WARNING')->end()
								->scalarNode('error')->info('Spelling for error level')->defaultValue('ERROR')->end()
								->scalarNode('alert')->info('Spelling for alert level')->defaultValue('ALERT')->end()
								->scalarNode('critical')->info('Spelling for critical level')->defaultValue('CRITICAL')->end()
								->scalarNode('emergency')->info('Spelling for emergency level')->defaultValue('EMERGENCY')->end()
							->end()
						->end()
					->end()
				->end()
			->end()
			->booleanNode('show_app_logs')->defaultTrue()->info('Show App logs in var/log')->end()
            ->scalarNode('app_pattern')->info('See ddtraceweb/monolog-parser for patterns.')->defaultNull()->end()
            ->scalarNode('app_date_format')->info('PHP style date format of app log files')->defaultNull()->end()
            ->booleanNode('logs_reverse')->defaultFalse()->info('Show log file as newest at the top')->end()
            ->booleanNode('use_carbon')->defaultFalse()->info('Use nesbot/carbon for date parsing')->end()
		->end();

		return $treeBuilder;
	}
}
