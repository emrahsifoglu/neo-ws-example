<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NeoWsFeedCommand extends ContainerAwareCommand
{

    protected function configure() {
        $this
            ->setName('neo:ws:feed')
            ->setDescription('Find Near Earth Objects in last 3 Days');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $container = $this->getContainer();

        $neoFacade = $container->get('facade.neo');
        $neoWs = $container->get('app.neo_ws');

        $contents = $neoWs->feedInLastDays(3);

        foreach ($contents as $date => $objects) {
            foreach ($objects as $object) {
                $neo = $neoFacade->createFromContent($object);
                $neoFacade->save($neo, false);
            }
        }

        $neoFacade->removeAll();
        $neoFacade->getDocumentManager()->flush();

        $response = $neoFacade->getTotalCount();

        $data = [
            '===================================================',
            '       Find Near Earth Objects in last 3 Days        ',
            '===================================================',
            $response
                ? sprintf('<info>It was successfully synchronized "%d" NEO(s)<info>', $response)
                : '<comment>Nothing to synchronize. Probably application already has all necessary data.</comment>',
            ''
        ];

        $output->writeln($data);

    }
}
