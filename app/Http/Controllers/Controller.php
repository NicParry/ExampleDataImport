<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function submitClientInfo(Request $request)
    {
        try {
            //delete all existing data in people and departments table
            DB::delete('DELETE FROM people');
            DB::delete('DELETE FROM departments');

            //split request content into lines
            $content = $request->getContent();
            $lines = explode("\n", $content);
            $peopleCount = 0;
            $departmentCount = 0;
            foreach ($lines as $line) {

                //split lines into fields and chunk into person and department
                $fields = explode("\t", $line);
                $chunks = array_chunk($fields, 4);
                $person = $chunks[0];
                $department = $chunks[1];

                //fetch existing department id or create new department
                $departmentName = array_slice($department, 0, 1);
                $departmentId = $this->getDepartmentIdByName($departmentName);
                if (!$departmentId) {
                    DB::insert('INSERT INTO departments(department_name, contact_name, contact_email) values (?,?,?)', $department);
                    $departmentId = $this->getDepartmentIdByName($departmentName);
                    $departmentCount++;
                }

                //insert new person
                $person[] = $departmentId;
                DB::insert('INSERT INTO people(first_name, surname, email, gender, department_id) values (?,?,?,?,?)', $person);
                $peopleCount++;
            }
        } catch (\Exception $e) {

            $response = new Response('Error while processing data', 400);
            return $response;
        }

        //return successful response
        $response = new Response("Client information successfully stored for $peopleCount people and $departmentCount departments", 201);
        return $response;
    }

    /**
     * @param $name
     * @return bool
     */
    private function getDepartmentIdByName($name)
    {
        $department = DB::select('SELECT * FROM departments WHERE department_name = ?', $name);
        if (count($department) > 0) {

            return $department[0]->id;
        }

        return false;
    }
}
