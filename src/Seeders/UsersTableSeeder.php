<?php

namespace Rutatiina\User\Seeders;

use Illuminate\Database\Seeder;
use Rutatiina\User\Models\User;
use Rutatiina\User\Models\UserDetails;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userId = 1;

        $user = User::create([
            'id' => $userId++,
            'name' => 'Gilbert Rutatiina',
            'email' => 'rutatiina@ruginem.org',
            'email_verified_at' => NULL,
            'password' => Hash::make('q@ssw0rb'),
            'api_token' => NULL,
            'remember_token' => 'lFE0lbVBEYlnzCHOs6cndocEwt9trg1WGHCaWpGaJUIlx7L40PSl9yhEjs6v',
            'created_at' => '2018-11-07 17:59:23',
            'updated_at' => '2018-11-07 17:59:23',
        ]);
        UserDetails::create([
            'user_id' => $user->id,
            'salutation' => 'Mr',
            'first_name' => 'testonh',
            'other_name' => 'Middle name',
            'image' => NULL,
            'billing_address_attention' => NULL,
            'billing_address_street1' => NULL,
            'billing_address_street2' => NULL,
            'billing_address_city' => NULL,
            'billing_address_state' => NULL,
            'billing_address_zip_code' => NULL,
            'billing_address_country' => NULL,
            'billing_address_fax' => NULL,
            'shipping_address_attention' => NULL,
            'shipping_address_street1' => NULL,
            'shipping_address_street2' => NULL,
            'shipping_address_city' => NULL,
            'shipping_address_state' => NULL,
            'shipping_address_zip_code' => NULL,
            'shipping_address_country' => NULL,
            'shipping_address_fax' => NULL,
        ]);
        $user->assignRole('super-admin');

        $user = User::create([
            'id' => $userId++,
            'name' => 'Qbuks Demo',
            'email' => 'demo@qbuks.com',
            'email_verified_at' => NULL,
            'password' => Hash::make('Qbuksdemo1'), //'$2y$10$iZmExXbWhgUu745jIzkXWOED1A0c/5vpJ2ME/BUDetsAiSxjzyO/u',
            'api_token' => NULL,
            'remember_token' => NULL,
            'created_at' => '2019-10-28 12:01:08',
            'updated_at' => '2019-10-28 12:01:08',
        ]);
        UserDetails::create([
            'user_id' => $user->id,
            'salutation' => NULL,
            'first_name' => NULL,
            'other_name' => NULL,
            'image' => NULL,
            'billing_address_attention' => NULL,
            'billing_address_street1' => 'kla',
            'billing_address_street2' => 'nairobi',
            'billing_address_city' => NULL,
            'billing_address_state' => NULL,
            'billing_address_zip_code' => '256',
            'billing_address_country' => 'UG',
            'billing_address_fax' => NULL,
            'shipping_address_attention' => NULL,
            'shipping_address_street1' => 'kla',
            'shipping_address_street2' => NULL,
            'shipping_address_city' => NULL,
            'shipping_address_state' => NULL,
            'shipping_address_zip_code' => '256',
            'shipping_address_country' => 'UG',
            'shipping_address_fax' => NULL,
        ]);
        $user->assignRole('super-admin');

        $user = User::create([
            'id' => $userId++,
            'name' => 'Robert Butamanya',
            'email' => '001@smsone.co.ug',
            'email_verified_at' => NULL,
            'password' => '$2y$10$5IKrsbq7su2inP6YmngAAe2f8.Q1iA/0Y33Oe60S54Z2lsNC.MIeq',
            'api_token' => NULL,
            'remember_token' => 'x1A4WvNaBu8z8ru6WN2SY1xkraBJoIQvtvnQkd3q9GuLEkzzOwIBaM6WOPbX',
            'created_at' => '2019-07-14 18:07:18',
            'updated_at' => '2019-07-14 18:07:18',
        ]);
        $user->assignRole('super-admin');

        $user = User::create([
            'id' => $userId++,
            'name' => 'user 001',
            'email' => 'user001@ruginem.org',
            'email_verified_at' => NULL,
            'password' => '$2y$10$4bPoadUsqD4QM5JVoxCAfugtdVPeBHDn7eIVWaBlAb/k6ZtVDszmu',
            'api_token' => NULL,
            'remember_token' => NULL,
            'created_at' => '2019-08-26 19:35:00',
            'updated_at' => '2019-08-26 19:35:00',
        ]);

        $user = User::create([
            'id' => $userId++,
            'name' => 'user 002',
            'email' => 'user002@ruginem.org',
            'email_verified_at' => NULL,
            'password' => '$2y$10$EXCskrRHrnVzGDpeOHiEDeXao6ID842rllSeSN7KarjgVXyJzY3VW',
            'api_token' => NULL,
            'remember_token' => 'idsa3FBdM7VxNXYF7OQbulEp2fUJCFPNvEY30qJRz2e4ZMiC4NGylBySgiaS',
            'created_at' => '2019-08-26 19:39:36',
            'updated_at' => '2019-08-26 19:39:36',
        ]);

        $user = User::create([
            'id' => $userId++,
            'name' => 'test01@mail.com',
            'email' => 'test01@mail.com',
            'email_verified_at' => NULL,
            'password' => '$2y$10$RgbgKgfSTCiW3t11p6KssugpQqVCD.6EPbGTe75AT69RHBx7KchUy',
            'api_token' => NULL,
            'remember_token' => NULL,
            'created_at' => '2019-10-24 10:18:43',
            'updated_at' => '2019-10-24 10:18:43',
        ]);

        $user = User::create([
            'id' => $userId++,
            'name' => 'test02@mail.com',
            'email' => 'test02@mail.com',
            'email_verified_at' => NULL,
            'password' => '$2y$10$ynfk1Rg7gWHMobjN2mh69O12KjjRcPi7rA6jRc81FAUalwCTnUGMC',
            'api_token' => NULL,
            'remember_token' => NULL,
            'created_at' => '2019-10-24 10:59:58',
            'updated_at' => '2019-10-24 10:59:58',
        ]);

        $user = User::create([
            'id' => $userId++,
            'name' => 'test03@mail.com',
            'email' => 'test03@mail.com',
            'email_verified_at' => NULL,
            'password' => '$2y$10$ssCb/gUBuzNmnQRw4jZn0OVo4TP1hl18u8uvQdDHx3yMOOeG7Q1JC',
            'api_token' => NULL,
            'remember_token' => NULL,
            'created_at' => '2019-10-24 11:01:47',
            'updated_at' => '2019-10-24 11:01:47',
        ]);

        $user = User::create([
            'id' => $userId++,
            'name' => 'test04@mail.com',
            'email' => 'test04@mail.com',
            'email_verified_at' => NULL,
            'password' => '$2y$10$3KpArHBHR8EFJbZQf0hmL.U6VS6tqZIfcACcsA7Zj4vcfGRTTR8yO',
            'api_token' => NULL,
            'remember_token' => NULL,
            'created_at' => '2019-10-24 11:21:55',
            'updated_at' => '2019-10-24 11:21:55',
        ]);
        UserDetails::create([
            'user_id' => $user->id,
            'salutation' => 'Mr',
            'first_name' => NULL,
            'other_name' => NULL,
            'image' => NULL,
            'billing_address_attention' => NULL,
            'billing_address_street1' => NULL,
            'billing_address_street2' => NULL,
            'billing_address_city' => NULL,
            'billing_address_state' => NULL,
            'billing_address_zip_code' => NULL,
            'billing_address_country' => NULL,
            'billing_address_fax' => NULL,
            'shipping_address_attention' => NULL,
            'shipping_address_street1' => NULL,
            'shipping_address_street2' => NULL,
            'shipping_address_city' => NULL,
            'shipping_address_state' => NULL,
            'shipping_address_zip_code' => NULL,
            'shipping_address_country' => NULL,
            'shipping_address_fax' => NULL,
        ]);

        $user = User::create([
            'id' => $userId++,
            'name' => 'test05@mail.com',
            'email' => 'test05@mail.com',
            'email_verified_at' => NULL,
            'password' => '$2y$10$MYSnh1BOTNtqorllfunclupSgWxfjTp1pE5uyl4/R3FSNxPIjAS1m',
            'api_token' => NULL,
            'remember_token' => NULL,
            'created_at' => '2019-10-24 11:22:33',
            'updated_at' => '2019-10-24 11:22:33',
        ]);
        UserDetails::create([
            'created_by' => $user->id,
            'user_id' => $user->id,
            'salutation' => NULL,
            'first_name' => NULL,
            'other_name' => NULL,
            'image' => NULL,
            'billing_address_attention' => NULL,
            'billing_address_street1' => 'kla',
            'billing_address_street2' => 'nairobi',
            'billing_address_city' => NULL,
            'billing_address_state' => NULL,
            'billing_address_zip_code' => '256',
            'billing_address_country' => 'UG',
            'billing_address_fax' => NULL,
            'shipping_address_attention' => NULL,
            'shipping_address_street1' => 'kla',
            'shipping_address_street2' => NULL,
            'shipping_address_city' => NULL,
            'shipping_address_state' => NULL,
            'shipping_address_zip_code' => '256',
            'shipping_address_country' => 'UG',
            'shipping_address_fax' => NULL,
        ]);

        $user = User::create([
            'id' => $userId++,
            'name' => 'test 100',
            'email' => 'test100@mail.com',
            'email_verified_at' => NULL,
            'password' => '$2y$10$iZmExXbWhgUu745jIzkXWOED1A0c/5vpJ2ME/BUDetsAiSxjzyO/u',
            'api_token' => NULL,
            'remember_token' => NULL,
            'created_at' => '2019-10-28 12:01:08',
            'updated_at' => '2019-10-28 12:01:08',
        ]);


        //very important
        //Change the autoincrement id to 500
        User::create(['id' => 499]);
        User::find(499)->forceDelete();

    }
}
