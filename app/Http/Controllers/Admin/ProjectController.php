<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Type;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // RECUPERO I TIPI DA ASSOCIARE AI PROGETTI
        $types = Type::all();

        return view('projects.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        // RECUPERO I TIPI DA ASSOCIARE AI PROGETTI
        $types = Type::all();

        return view('projects.edit', compact('project', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {

        // RECUPERO I DATI DELLA RICHIESTA
        $form_data = $request->all();

        // CONTROLLO PER VERIFICARE CHE IL 'name' SIA UNIQUE O NO
        $exists = Project::where('name', 'LIKE', $form_data['name'])->where('id', '!=', $project->id)->get();
        if (count($exists) > 0) {
            $error_message = 'The project name already exist!';
            return redirect()->route('admin.projects.edit', ['project' =>  $project->slug], compact('error_message'));
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
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
