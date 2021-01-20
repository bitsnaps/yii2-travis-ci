<?php
namespace app\tests\fixtures;

use yii\test\ActiveFixture;
use app\models\User;

class UserFixture extends ActiveFixture
{

    // public $tableName = 'user';
    // where `FixturePath` points to this directory (set to false to disable this fixture)
    // public $dataFile = 'FixturePath/data/TableName.php';

    public $modelClass = User::class;

    // if UserFixture depends on other fixture
    // public $depends = ['app\tests\fixtures\BaseUserFixture'];

}
