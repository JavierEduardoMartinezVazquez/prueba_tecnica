<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function showAllTask(){
        $tasks = Task::all();
        if( $tasks->isEmpty()){
            $data = [
                'mensaje' => 'Sin tareas',
                'status' => '400'
            ];
            return response()->json($data, 400);
        }
        $data = [
            'tasks' => $tasks,
            'status' => '200'
        ];
        return response()->json($tasks, 200);
    }

    public function showTask($id){
        $task = Task::find($id);

        if(!$task){
            $data = [
                'mensaje' => 'Tarea no encontradaa',
                'status' => '404'
            ];
            return response()->json($data, 404);
        }
        $data = [
            'tasks' => $task,
            'status' => '200'
        ];
        return response()->json($task, 200);

    }

    public function storeTask(Request $request){
        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'description'=>'required',
            'status'=>'required|in:Pendiente,En proceso,Completada'
        ]);

        if ($validator->fails()){
            $data= [
                'mensaje' => 'Todos los datos son requeridos ',
                'errors' => $validator->errors(),
                'status' => '400'
            ];
            return response()->json($data, 400);
        }
        $tasks = Task::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'status'=>$request->status
        ]);

        if(!$tasks){
            $data = [
                'mensaje' => 'Error al guardar la tarea',
                'status' => '500'
            ];
            return response()->json($data, 500);
        }

        $data = [
            'task' => $tasks,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function deleteTask($id){
        $task = Task::find($id);

        if(!$task){
            $data = [
                'mensaje' => 'Tarea no encontradaa',
                'status' => '404'
            ];
            return response()->json($data, 404);
        }

        $task->delete();

        $data = [
            'message' => 'TAREA ELIMINADA',
            'status' => '200'
        ];
        return response()->json($data, 200);
    }
    public function updateTask(Request $request, $id){
        $task = Task::find($id);
        if(!$task){
            $data = [
                'mensaje' => 'Tarea no encontradaa',
                'status' => '404'
            ];
            return response()->json($data, 404);
        }
        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'description'=>'required',
            'status'=>'required|in:Pendiente,En proceso,Completada'
        ]);
        if ($validator->fails()){
            $data= [
                'mensaje' => 'Todos los datos son requeridos ',
                'errors' => $validator->errors(),
                'status' => '400'
            ];
            return response()->json($data, 400);
        }
        $task -> title = $request->title;
        $task -> description= $request->description;
        $task -> status= $request->status;

        $task->save();

        $data = [
                'mensaje' => 'Tarea actualizada',
                'task' => $task,
                'status' => '200'
        ];
        return response()->json($data, 200);

    }

    public function updateAloneValTask(Request $request, $id){
        $task = Task::find($id);
        if(!$task){
            $data = [
                'mensaje' => 'Tarea no encontradaa',
                'status' => '404'
            ];
            return response()->json($data, 404);
        }
        $validator = Validator::make($request->all(),[
            'status'=>'in:Pendiente,En proceso,Completada'
        ]);
        if ($validator->fails()){
            $data= [
                'mensaje' => 'Error',
                'errors' => $validator->errors(),
                'status' => '400'
            ];
            return response()->json($data, 400);
        }
        if ($request->has('title')){
            $task -> title = $request->title;
        }
        if ($request->has('description')){
            $task -> description = $request->description;
        }
        if ($request->has('status')){
            $task -> status = $request->status;
        }

        $task->save();

        $data = [
                'mensaje' => 'Tarea actualizada',
                'task' => $task,
                'status' => '200'
        ];
        return response()->json($data, 200);

    }
}

