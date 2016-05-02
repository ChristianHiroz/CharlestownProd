<?php

namespace Charlestown\DemandBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Charlestown\FileBundle\Form\FileType;

class DemandVacancyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reason','choice', array(
                'choices'   => array('Congés Payés' => 'Congés Payés',
                    'Capital temps pour Maternité' => 'Capital temps pour Maternité',
                    'Compte épargne Temps' => 'Compte épargne Temps',
                    'Congé Enfant Hospitalisé' => 'Congé Enfant Hospitalisé',
                    'Congé enfant Malade non Rémunéré(3 premiers jours)' => 'Congé enfant Malade non Rémunéré(3 premiers jours)',
                    'Congé enfant Malade Rémunéré (4 derniers jours/ 7)' => 'Congé enfant Malade Rémunéré (4 derniers jours/ 7)',
                    'Congé Mariage Parents / Enfant' => 'Congé Mariage Parents / Enfant',
                    'Congé Obsèques beaux-parents' => 'Congé Obsèques beaux-parents',
                    'Congé Obsèques Conjoint' => 'Congé Obsèques Conjoint',
                    'Congé Obsèques Enfant' => 'Congé Obsèques Enfant',
                    'Congé Obsèques Frère/Soeur' => 'Congé Obsèques Frère/Soeur',
                    'Congé Obsèques Parents' => 'Congé Obsèques Parents',
                    'CONGE PACS' => 'CONGE PACS',
                    'Congé Paternité' => 'Congé Paternité',
                    'Congés Décés grands parents' => 'Congés Décés grands parents',
                    'Congés Mariage' => 'Congés Mariage',
                    'Congés Naissance' => 'Congés Naissance',
                    'Congés Sans solde' => 'Congés Sans solde',
                    'Heures Visite Grossesse' => 'Heures Visite Grossesse',
                    'Jour de Fractionnement' => 'Jour de Fractionnement',
                    'Jour Déménagement' => 'Jour Déménagement',
                    'Jour Récupération' => 'Jour Récupération',
                    'Repos Compensateur' => 'Repos Compensateur',
                    'RTT' => 'RTT'),
                'required'  => true, 'label' => ('Motif')))
            ->add('comment','text', array('label' => 'Commentaire'))
            ->add('dateStart','date', array('label' => 'Date début'))
            ->add('dateEnd','date', array('label' => 'Date fin'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Charlestown\DemandBundle\Entity\Demand'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'charlestown_demandbundle_demand';
    }
}
