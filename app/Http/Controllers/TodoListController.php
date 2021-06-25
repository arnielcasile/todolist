<?php

namespace App\Http\Controllers;

use App\TodoList;
use App\Http\Requests\TodoListRequest;
use App\Services\TodoListService;
use App\Traits\ResponseTraits;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

class TodoListController extends Controller
{
    use ResponseTraits;

    protected $todoListService;

    public function __construct(TodoListService $todoListService)
    {
        $this->todoListService = $todoListService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $result = $this->successResponse("Load All TodoList Successfully");
        try {
            $result["data"] = $this->todoListService->loadAll();
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }

        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoListRequest $request)
    {
        $result = $this->successResponse("Inserted Successfully");

        try {
            $data = [
                'name'                  => $request->name,
                'completion_datetime'   => $request->completion_datetime,
                'deadline_datetime'     => $request->deadline_datetime,
            ];
            $this->todoListService->create($data);
        } catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->successResponse("Get TodoList Successfully");
        try {
            $result["data"] = $this->todoListService->find($id);
        }
        catch (ModelNotFoundException $except)
        {
            $result = $this->modelNotFoundResponse($id);
        } 
        catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }

        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function update($id, TodoListRequest $request)
    {
        $result = $this->successResponse("Updated Successfully");

        try {
            $data = [
                'name'                  => $request->name,
                'completion_datetime'   => $request->completion_datetime,
                'deadline_datetime'     => $request->deadline_datetime,
            ];
            $this->todoListService->update($id, $data);
        }
        catch (ModelNotFoundException $except)
        {
            $result = $this->modelNotFoundResponse($id);
        }  
        catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }

        return $result;
    }

    public function complete($id)
    {
        $result = $this->successResponse("Updated Successfully");

        try {
            $check = $this->todoListService->find($id);
            if($check->completion_datetime === null)
            {
                $data = [
                    'completion_datetime'     => Carbon::now()->toDateString()
                ];
            }
            else
            {
                $data = [
                    'completion_datetime'     => null
                ];
            }
            $this->todoListService->update($id, $data);
        }
        catch (ModelNotFoundException $except)
        {
            $result = $this->modelNotFoundResponse($id);
        }  
        catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->successResponse("Deleted Successfully");
        try {
            $this->todoListService->deleted($id);
        }
        catch (ModelNotFoundException $except)
        {
            $result = $this->modelNotFoundResponse($id);
        } 
        catch (\Exception $e) {
            $result = $this->errorResponse($e);
        }

        return $result;
    }
}
