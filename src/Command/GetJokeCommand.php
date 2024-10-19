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

    public function __construct(private HttpClientInterface $client, private CacheInterface $pool, private LoggerInterface $logger)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->progressStart(100);

        try {
            $startTime = microtime(true);
            $client = $this->client;

            //si l'élement n'existe pas : appel api + mise en cache 
            $this->pool->get('joke', function (ItemInterface $item) use ($client): string {
                $item->expiresAfter(new \DateInterval('P1D'));
                $response = $client->request(
                    'GET',
                    'http://official-joke-api.appspot.com/random_joke'
                );
                $content = $response->toArray();
                return $content['setup'] . ' : ' . $content['punchline'];
            });

            $io->progressAdvance(100);
            $io->progressFinish();

            $endTime = microtime(true);
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
