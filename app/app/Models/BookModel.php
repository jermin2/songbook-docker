<?php namespace App\Models;
use CodeIgniter\Model;
use \stdClass;

class BookModel extends Model {

    protected $table = 'book_table';
    protected $allowedFields = ['name', 'songids', 'params'];

    public function getBook($book_id)
    {
        $result = $this->asArray()
            ->where(['id'=> $book_id])
            ->first();

        return $result;
    }

    public function getList()
    {
        return $this->asArray()
            ->select('id, name')
            ->orderBy('name', 'ASC')
            ->findAll();
    }

}