<?php
namespace Charlestown\CollaboratorBundle\Command;

use Charlestown\CustomerBundle\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

use Charlestown\CollaboratorBundle\Entity\Collaborator;
use Symfony\Component\Validator\Constraints\DateTime;

class ImportCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        // Name and description for app/console command
        $this
            ->setName('import:collaborator:csv')
            ->setDescription('Import collaborator from CSV file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Showing when the script is launched
        $now = new \DateTime();
        $output->writeln('<comment>Start : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');

        // Importing CSV on DB via Doctrine ORM
        $this->import($input, $output);

        // Showing when the script is over
        $now = new \DateTime();
        $output->writeln('<comment>End : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
    }

    protected function import(InputInterface $input, OutputInterface $output)
    {
        // Getting php array of data from CSV
        $data = $this->get($input, $output, "collaborator");
        $dataClient = $this->get($input, $output, "client");

        // Getting doctrine manager
        $em = $this->getContainer()->get('doctrine')->getManager();
        // Turning off doctrine default logs queries for saving memory
        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        // Define the size of record, the frequency for persisting the data and the current index of records
        $size = count($data);
        $batchSize = 20;
        $i = 1;
        $j = 1;

        // Starting progress
        $progress = new ProgressBar($output, $size);
        $progress->start();

        // Processing on each row of data
        foreach($data as $row) {

            //Create new collaborator, find his agency, format his birth date
            $collaborator = new Collaborator();
            $birthDate = \DateTime::createFromFormat('d/m/Y', $row['Date_Naissance']);
            $agency = $em->getRepository('CharlestownAgencyBundle:Agency')->find($row['group_name']);
            //Update is infos
            $collaborator->setUsername($row['users_login']);
            $collaborator->setPlainPassword($row['password']);
            $collaborator->setEmail($row['users_email']);
            $collaborator->setLastName($row['users_surname']);
            $collaborator->setFirstName($row['users_name']);
            $collaborator->setEnabled($row['active']);
            $collaborator->setAgency($agency);
            $collaborator->setAddress($row['adresse']);
            $collaborator->setPc($row['code_postal']);
            $collaborator->setTown($row['ville']);
            $collaborator->setPortPhoneNumber($row['portable']);
            $collaborator->setPhoneNumber($row['telephone']);
            $collaborator->setBirthDate($birthDate);

            // Do stuff here !

            // Persisting the current user
            $em->persist($collaborator);

            // Each 20 users persisted we flush everything
            if (($i % $batchSize) === 0) {

                $em->flush();
                // Detaches all objects from Doctrine for memory save
                $em->clear();

                // Advancing for progress display on console
                $progress->advance($batchSize);

                $now = new \DateTime();
                $output->writeln(' of users imported ... | ' . $now->format('d-m-Y G:i:s'));

            }

            $i++;

        }

        //Same for Client TODO
        foreach($dataClient as $row){

        }

        // Flushing and clear data on queue
        $em->flush();
        $em->clear();

        // Ending the progress bar process
        $progress->finish();
    }

    protected function get(InputInterface $input, OutputInterface $output, $type)
    {
        // Getting the CSV from filesystem
        if($type == "collaborator"){
            $fileName = 'web/uploads/csv/Charles_users.csv';
        }
        elseif($type == "client"){
            $fileName = 'web/uploads/csv/Charles_clients.csv';
        }
        else{
            return null;
        }

        // Using service for converting CSV to PHP Array
        $converter = $this->getContainer()->get('import.csvtoarray');
        $data = $converter->convert($fileName, ';');

        return $data;
    }

}