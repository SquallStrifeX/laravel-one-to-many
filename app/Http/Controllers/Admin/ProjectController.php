<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(StoreProjectRequest $request)
    {
        // RECUPERO I DATI DELLA RICHIESTA
        $form_data = $request->all();

        // Controllo che request con chiave img contenga un file
        if ($request->hasFile('img')) {
            // Recupero il path dell'immagine caricata dall'utente
            $img_path = Storage::disk('public')->put('project_images', $form_data['img']);

            // Applico il valore della variabile all immagine
            $form_data['img'] = $img_path;
        };

        // CREO UNA NUOVA ISTANZA DI PROJECT
        $project = new Project;

        // DEFINISCO LO SLUG
        $slug = Str::slug($form_data['name'], '-');

        // DO IL VALORE DELLO SLUG DEFINITO ALLA RICHIESTA
        $form_data['slug'] = $slug;

        // USO IL FILL PER RIEMPIRE I CAMPI
        $project->fill($form_data);

        // SALVO LA NUOVA ISTANZA
        $project->save();

        // FACCIO UN REDIRECT ALLA PAGINA PRINCIPALE DI PROJECTS
        return redirect()->route('admin.projects.index');
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        // RECUPERO I DATI DELLA RICHIESTA
        $form_data = $request->all();

        // CONTROLLO PER VERIFICARE CHE IL 'name' SIA UNIQUE O NO
        $exists = Project::where('name', 'LIKE', $form_data['name'])->where('id', '!=', $project->id)->get();
        if (count($exists) > 0) {
            return redirect()->route('admin.projects.show', ['project' =>  $project->slug]);
        }

        // Controllo che request con chiave img contenga un file
        if ($request->hasFile('img')) {

            // Controllo che l'immagine sia diversa da 'null'
            if ($project->img != null) {
                // Se non è diversa da null procedo con la cancellazione dell'immagine
                Storage::disk('public')->delete($project->img);
            }

            // Recupero il path dell'immagine caricata dall'utente
            $img_path = Storage::disk('public')->put('project_images', $form_data['img']);
            // Applico il valore della variabile all immagine
            $form_data['img'] = $img_path;
        };

        // DEFINISCO LO SLUG
        $slug = Str::slug($form_data['name'], '-');

        // DO IL VALORE DELLO SLUG DEFINITO ALLA RICHIESTA
        $form_data['slug'] = $slug;

        // USO IL FILL PER RIEMPIRE I CAMPI
        $project->update($form_data);

        // FACCIO UN REDIRECT ALLA PAGINA PRINCIPALE DI PROJECTS
        return redirect()->route('admin.projects.show', ['project' =>  $project->slug]);
    }

    public function destroy(Project $project)
    {
        // Controllo che l'immagine sia diversa da 'null'
        if ($project->img != null) {
            // Se non è diversa da null procedo con la cancellazione dell'immagine
            Storage::disk('public')->delete($project->img);
        }

        $project->delete();
        return redirect()->route('admin.projects.index');
    }
}
