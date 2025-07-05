<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Jobs\DeleteTaskLater;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        $tasks = Cache::tags(['tasks'])->remember('tasks.all', now()->addMinutes(5), function () {
            return Task::get()->toArray();
        });

        return  response()->json([ 'Ok' => true, 'data' => $tasks], 200);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        try {
            $task = $request->validated();

            Task::create([
                'title' => $task['title'],
                'description' => $task['description'] ?? null,
                'limit_date' => $task['limit_date'],
                'finish' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Cache::tags(['tasks'])->flush();

            return  response()->json([ 'Ok' => true, 'message' => "Tarefa cadastrada com sucesso!"], 200);

        } catch (Exception $e) {
            Log::error("Erro ao inserir tarefa:", [$e->getMessage()]);

            return  response()->json([ 'Ok' => false, 'message' => "Não foi possível inserir tarefa."], 500);
        }
    }

    public function update(StoreTaskRequest $request, int $id)
    {
        try {
            $data = $request->validated();
            $task = Task::findorFail($id);

            $task->update([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'limit_date' => $data['limit_date'],
                'updated_at' => now(),
            ]);

            Cache::tags(['tasks'])->flush();

            return  response()->json([ 'Ok' => true, 'message' => "Tarefa atualizada com sucesso!"], 200);

        } catch (Exception $e) {
            Log::error("Erro ao atualizar tarefa:", [$e->getMessage()]);

            return  response()->json([ 'Ok' => false, 'message' => "Não foi possível atualizar a tarefa."], 500);
        }
    }

    public function changeStatus(Request $request, int $id)
    {
        try {
            $task = Task::findorFail($id);

            $task->update([
                'finish' => $request->status,
            ]);

            // ⏱️ Job será executado em 10 minutos
            DeleteTaskLater::dispatch($task->id)->delay(now()->addMinutes(10));

            return  response()->json([ 'Ok' => true, 'message' => "Status atualizado com sucesso!"], 200);
        } catch (Exception $e) {
            Log::error("Erro ao atualizar status da tarefa:", [$e->getMessage()]);

            return  response()->json([ 'Ok' => false, 'message' => "Não foi possível alterar status da tarefa."], 500);
        }
    }

    public function delete(int $id)
    {
        try {
            $task = Task::findorFail($id);
            $task->delete();

            Cache::tags(['tasks'])->flush();

            return  response()->json([ 'Ok' => true, 'message' => "Tarefa excluída com sucesso!"], 200);
        } catch (Exception $e) {
            Log::error("Erro ao excluir tarefa:", [$e->getMessage()]);

            return  response()->json([ 'Ok' => false, 'message' => "Não foi possível excluir a tarefa. Tente novamente."], 500);
        }
    }
}
