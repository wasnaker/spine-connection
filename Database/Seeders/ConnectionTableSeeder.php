<?php

namespace Modules\Connection\Database\Seeders;

use Illuminate\Database\Seeder;

class ConnectionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('connections')->delete();
        
        \DB::table('connections')->insert(array (
            0 => 
            array (
                'id' => 1,
                'ulid' => '01m208yb4zssbcwfcb97ksh3px',
                'token' => '0ygQQiMlPhn2B9r4eKZNb1tNIaUIK4tnymiXkKExjyXG3xt2',
                'customer_id' => 20792,
                'surveyor_id' => NULL,
                'status' => 'cancelled',
                'created_by' => 10320,
                'approved_by' => NULL,
                'approved_at' => NULL,
                'created_at' => '2026-09-08 10:27:41',
                'updated_at' => '2026-09-08 10:56:13',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'ulid' => '01m20ajvp68221xj6q9pbcmsj7',
                'token' => '5XnPakCrWznu6wwbwW5vbFYVKsKYKEpIgA5PmUnwef6MNSqo',
                'customer_id' => 20792,
                'surveyor_id' => NULL,
                'status' => 'pending',
                'created_by' => 10320,
                'approved_by' => NULL,
                'approved_at' => NULL,
                'created_at' => '2026-09-08 10:56:22',
                'updated_at' => '2026-09-08 10:56:22',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'ulid' => '01m20s44rhs59xh5msqfkdpqbt',
                'token' => 'AMHoHizcvqj31Quhde5LL2VcvEr7wRaKR4v9NeDRF8MekeMF',
                'customer_id' => 20792,
                'surveyor_id' => 50129,
                'status' => 'active',
                'created_by' => 30429,
                'approved_by' => 10320,
                'approved_at' => '2026-09-08 16:25:14',
                'created_at' => '2026-09-08 15:10:29',
                'updated_at' => '2026-09-08 16:25:14',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'ulid' => '01m21w4h0y7fn0e6kmk18zn429',
                'token' => 'kfwZwkuNpljkoDe6YRS2brqeMZ9VOO05vOVcPoLAoZ0xgL0J',
                'customer_id' => 20721,
                'surveyor_id' => 50100,
                'status' => 'active',
                'created_by' => 10249,
                'approved_by' => 30373,
                'approved_at' => '2026-09-09 01:22:21',
                'created_at' => '2026-09-09 01:22:21',
                'updated_at' => '2026-09-09 01:22:21',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'ulid' => '01m21w4h17a1k5aq8pmy58zwvq',
                'token' => 'seAudA88kCZIgeJP0OwiJxNoSSlAKGCBAJqseRrtsNBUGNaF',
                'customer_id' => 20722,
                'surveyor_id' => 50104,
                'status' => 'active',
                'created_by' => 10250,
                'approved_by' => 30377,
                'approved_at' => '2026-09-09 01:22:21',
                'created_at' => '2026-09-09 01:22:21',
                'updated_at' => '2026-09-09 01:22:21',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'ulid' => '01m21w4h198y7bfegqgsa8q0ar',
                'token' => 'xiJWqsrTYhIgI6CdkdcVIAiAaQfjmGM9pYUqc2PlpsNNUfv4',
                'customer_id' => 20723,
                'surveyor_id' => 50108,
                'status' => 'active',
                'created_by' => 10251,
                'approved_by' => 30381,
                'approved_at' => '2026-09-09 01:22:21',
                'created_at' => '2026-09-09 01:22:21',
                'updated_at' => '2026-09-09 01:22:21',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'ulid' => '01m21w4h1brw0b96qyb9qa4k1v',
                'token' => 'pEg6KctkofaSJXcEiFmAdmMQn2J1V1fiOhJsaUnxPdFIrokl',
                'customer_id' => 20724,
                'surveyor_id' => 50112,
                'status' => 'active',
                'created_by' => 30385,
                'approved_by' => 10252,
                'approved_at' => '2026-09-09 01:22:21',
                'created_at' => '2026-09-09 01:22:21',
                'updated_at' => '2026-09-09 01:22:21',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'ulid' => '01m21w4h1e6jzg4cwkn2k32mnd',
                'token' => '2dShZd8xx6AuNwb4KMmeLo8tFTRTLRqJBo3D2J6kSE1akpkr',
                'customer_id' => 20725,
                'surveyor_id' => 50116,
                'status' => 'active',
                'created_by' => 30416,
                'approved_by' => 10253,
                'approved_at' => '2026-09-09 01:22:21',
                'created_at' => '2026-09-09 01:22:21',
                'updated_at' => '2026-09-09 01:22:21',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'ulid' => '01m21w7gackskp3wcy639af2rh',
                'token' => 'm2g4ysbN2ET1NQyXPgRyinDAywXy4JDxfdGCe0tRqvLbHKSw',
                'customer_id' => 20721,
                'surveyor_id' => 50120,
                'status' => 'active',
                'created_by' => 10249,
                'approved_by' => 30420,
                'approved_at' => '2026-09-09 01:23:59',
                'created_at' => '2026-09-09 01:23:59',
                'updated_at' => '2026-09-09 01:23:59',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'ulid' => '01m21w7gawcj0ge97ntz4w8133',
                'token' => '9sojiIgybTpuPFafAYIi9CCOVzy0jy3jgehhefIkbizyj9lp',
                'customer_id' => 20721,
                'surveyor_id' => 50124,
                'status' => 'active',
                'created_by' => 10249,
                'approved_by' => 30424,
                'approved_at' => '2026-09-09 01:23:59',
                'created_at' => '2026-09-09 01:23:59',
                'updated_at' => '2026-09-09 01:23:59',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'ulid' => '01m21w7gb1jfh575cp2xa2cyvw',
                'token' => 'eHxb42lyJhGnG0dWU81cJXd6GC9HlKt5e9rKBJCZWJ5FjKyu',
                'customer_id' => 20726,
                'surveyor_id' => 50100,
                'status' => 'active',
                'created_by' => 30373,
                'approved_by' => 10254,
                'approved_at' => '2026-09-09 01:23:59',
                'created_at' => '2026-09-09 01:23:59',
                'updated_at' => '2026-09-09 01:23:59',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'ulid' => '01m21w7gb5d2ht68tqtw2ncawq',
                'token' => '5c1zIQVI5eegUukXj0EHMQTKaR22n8IHufQeynFLlcmc7Tiy',
                'customer_id' => 20727,
                'surveyor_id' => 50100,
                'status' => 'active',
                'created_by' => 10255,
                'approved_by' => 30373,
                'approved_at' => '2026-09-09 01:23:59',
                'created_at' => '2026-09-09 01:23:59',
                'updated_at' => '2026-09-09 01:23:59',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'ulid' => '01m21wctbah18kq7hrf1m9j4gf',
                'token' => 'F0PLIRJTPpKVyg5WbvWFWuQD4TJTaTngX6zGGenBUwLR31Do',
                'customer_id' => 20770,
                'surveyor_id' => 50100,
                'status' => 'active',
                'created_by' => 10298,
                'approved_by' => 30373,
                'approved_at' => '2026-09-09 01:26:53',
                'created_at' => '2026-09-09 01:26:53',
                'updated_at' => '2026-09-09 01:26:53',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'ulid' => '01m21wctbzwnrq80489624vybk',
                'token' => 'hxwEKTMI32Rxf3F228vjY26vWCCcjiU2VgvnXj0yT25B2JSD',
                'customer_id' => 20770,
                'surveyor_id' => 50104,
                'status' => 'active',
                'created_by' => 10298,
                'approved_by' => 30377,
                'approved_at' => '2026-09-09 01:26:53',
                'created_at' => '2026-09-09 01:26:53',
                'updated_at' => '2026-09-09 01:26:53',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'ulid' => '01m21wctc5d6mcrm6p1ssyr5v3',
                'token' => 'i12pOidZRlH3NGfCZOHHrs5F3jN2x2YSIjjcZhKEKXfwVMlx',
                'customer_id' => 20770,
                'surveyor_id' => 50108,
                'status' => 'active',
                'created_by' => 10298,
                'approved_by' => 30381,
                'approved_at' => '2026-09-09 01:26:53',
                'created_at' => '2026-09-09 01:26:53',
                'updated_at' => '2026-09-09 01:26:53',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'ulid' => '01m21wctcaj3gx10t46vypf2rr',
                'token' => 'dsHBcNkqWgxwqATzugv0Ez8T7XpeM1Nx1y3E5wmjFEBzE1gD',
                'customer_id' => 20771,
                'surveyor_id' => 50100,
                'status' => 'active',
                'created_by' => 10299,
                'approved_by' => 30373,
                'approved_at' => '2026-09-09 01:26:53',
                'created_at' => '2026-09-09 01:26:53',
                'updated_at' => '2026-09-09 01:26:53',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'ulid' => '01m21wfd9yy4prqzrz2rr10gh1',
                'token' => 'oav4f7jeEJx7G5HEv2BAPChW2Ojr0Im97TLp3jcl2PmQ9oSb',
                'customer_id' => 20726,
                'surveyor_id' => 50101,
                'status' => 'active',
                'created_by' => 30374,
                'approved_by' => 10254,
                'approved_at' => '2026-09-09 01:28:18',
                'created_at' => '2026-09-09 01:28:18',
                'updated_at' => '2026-09-09 01:28:18',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'ulid' => '01m21wfdak0pw789sbjp6k9rf8',
                'token' => 'Q4fC3hfJ27siolYl0dAxQS7RbkI1JagNSP5QTdIJGd6LpsDz',
                'customer_id' => 20727,
                'surveyor_id' => 50101,
                'status' => 'active',
                'created_by' => 30374,
                'approved_by' => 10255,
                'approved_at' => '2026-09-09 01:28:18',
                'created_at' => '2026-09-09 01:28:18',
                'updated_at' => '2026-09-09 01:28:18',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'ulid' => '01m21wfdatvd9b7w68gb38ndaw',
                'token' => 'VymZOcPLKs6fR6Q3TIGW5SKJDeETzsaSa20u1QxxAR3xV2GV',
                'customer_id' => 20728,
                'surveyor_id' => 50101,
                'status' => 'active',
                'created_by' => 30374,
                'approved_by' => 10256,
                'approved_at' => '2026-09-09 01:28:18',
                'created_at' => '2026-09-09 01:28:18',
                'updated_at' => '2026-09-09 01:28:18',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'ulid' => '01m21wfdb1n9vgmt3yxt93sytc',
                'token' => 'hwvBC8xVxJULTovhhiQsm8Wc73ojZONLx6sBTESKln4B168z',
                'customer_id' => 20723,
                'surveyor_id' => 50105,
                'status' => 'active',
                'created_by' => 30378,
                'approved_by' => 10251,
                'approved_at' => '2026-09-09 01:28:18',
                'created_at' => '2026-09-09 01:28:18',
                'updated_at' => '2026-09-09 01:28:18',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}