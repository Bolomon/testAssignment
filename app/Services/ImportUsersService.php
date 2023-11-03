<?php

namespace App\Services;

use App\Contracts\ImportUsersContract;
use App\Models\ImportUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class ImportUsersService implements ImportUsersContract {
    const URL = "https://randomuser.me/api/";
    private Model $userModel;

    /**
     * @param \Illuminate\Database\Eloquent\Model $userModel
     * @return void
     */
    public function setUserModel(Model $userModel): void
    {
        $this->userModel = $userModel;
    }

    /**
     * @param int $count
     * @param int $page
     * @return array
     */
    public function import(int $count = 5000, int $page = 1): array
    {
        $data = $this->getData($count, $page);
        $dataFormated = $this->dataFormated($data['results']); 
        $rowsCountBeforeUpsert = ImportUser::count();
        ImportUser::upsert($dataFormated, ['email'], ['first_name', 'last_name', 'age']);
        $rowsCountAfterUpsert = ImportUser::count();

        return $this->getImportResult($rowsCountBeforeUpsert, count($dataFormated), $rowsCountAfterUpsert);
    }

    /**
     * @param int $rowsCountBeforeUpsert
     * @param int $dataCount
     * @param int $rowsCountAfterUpsert
     * @return array
     */
    private function getImportResult(int $rowsCountBeforeUpsert, int $dataCount, int $rowsCountAfterUpsert):array
    {
        $addedRows = $rowsCountAfterUpsert - $rowsCountBeforeUpsert;
        $updatedRows = $dataCount - $addedRows;

        return [
            'total' => $rowsCountAfterUpsert,
            'added' => $addedRows,
            'updated' => $updatedRows,
        ];
    }

    /**
     * @param int $count
     * @param int $page
     * @return array|\Throwable
     */
    private function getData(int $count = 5000, int $page = 1): array|\Throwable
    {
        try {
            $response = Http::get(self::URL, [
                'results' => $count,
                'page' => $page,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $response->json();
    }

    private function dataFormated(array $data): array
    {
        $formatedData = [];
        foreach ($data as $value) {
            $formatedData[$value['email']] = [
                'first_name' => $value['name']['first'],
                'last_name' => $value['name']['last'],
                'email'=> $value['email'],
                'age'=> $value['dob']['age'],
            ];
        }

        return $formatedData;
    }

}