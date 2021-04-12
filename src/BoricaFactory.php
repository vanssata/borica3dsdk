<?php
declare(strict_types=1);

namespace Vanssa\BoricaSDK;


use Symfony\Component\OptionsResolver\OptionsResolver;

class BoricaFactory implements BoricaFactoryInterface
{

    public static function create(): Borica
    {
      return new Borica();
    }

    public static function createWhitData(array $options): Borica
    {
        $options = self::resovleBoricaOptions($options);
        $borica = BoricaFactory::create();

        if($options['IsKeyFromString'] === true){
            $borica
                ->setPrivateKeyFromString($options['PrivateKey'])
                ->setCertificateFromString($options['Certificate']);
        }else{
            $borica->setPrivateKeyFromFile($options['PrivateKey'])
                ->setCertificateFromFile($options['Certificate']);
        }
        $borica
            ->setMacMode($options['MacMode'])
            ->setPrivateKeyPassword($options['PrivateKeyPassword'])
            ->setSandboxMode($options['SandboxMode']);
        return  $borica;
    }

    private static function resovleBoricaOptions(array $borica_options):array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired([
            'IsKeyFromString',
            'PrivateKey',
            'PrivateKeyPassword',
            'Certificate',
            'SandboxMode',
            'MacMode',
        ]);
        $resolver->setAllowedTypes('SandboxMode','bool');
        $resolver->setAllowedTypes('IsKeyFromString','bool');
        $resolver->setAllowedTypes('PrivateKey','string');
        $resolver->setAllowedTypes('Certificate','string');
        $resolver->setAllowedTypes('PrivateKeyPassword',['string','null']);
        $resolver->setAllowedTypes('MacMode',['string','null']);

        $resolver->setAllowedValues('MacMode',Borica::MAC_MOD);

        $resolver->setDefault('IsKeyFromString',true);
        $resolver->setDefault('SandboxMode',true);
        $resolver->setDefault('PrivateKeyPassword','');
        $resolver->setDefault('MacMode',Borica::MAC_MOD['extended']);

        return $resolver->resolve($borica_options);
    }
}
