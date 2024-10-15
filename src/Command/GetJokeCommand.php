<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Psr\Log\LoggerInterface;

#[AsCommand(
    name: 'app:get-joke',
    description: 'Get a joke',
)]
class GetJokeCommand extends Command
{
    private $logger;

    public function __construct(private HttpClientInterface $client, private CacheInterface $pool, LoggerInterface $logger)
    {
        $this->logger = $logger;
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $startTime = microtime(true);
            $output->writeln('Début du traitement');

            //appel api
            $response = $this->client->request(
                'GET',
                'http://official-joke-api.appspot.com/random_joke'
            );
            $content = $response->getContent();
            $content = $response->toArray();

            //mise en cache
            $this->pool->get('joke', function (ItemInterface $item) use ($content): string {
                $item->expiresAfter(new \DateInterval('P1D'));
                $computedValue = $content['setup'] . ' : ' . $content['punchline'];
                return $computedValue;
            });

            $endTime = microtime(true);
            $output->writeln('Fin du traitement');
            $executionTime = date('H:i:s', $endTime - $startTime);
            $output->writeln('Temps d\'exécution : ' . $executionTime);

            $io->success('Success');
        } catch (\Exception $e) {
            $this->logger->debug('Command GetJoke : ' . $e->getMessage());
            $io->error('Error : ' . $e->getMessage());
        
            return Command::FAILURE;
        }

        return Command::SUCCESS;   
    }
}
