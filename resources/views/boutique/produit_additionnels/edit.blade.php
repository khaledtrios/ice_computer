@csrf
<input type="hidden" class="edit_produit_id" name="id" value="{{ $produit->id }}">
@csrf
<div class="col-md-6">
    <label class="form-label" for="materielId">Matériel</label>
    <select class="form-control" id="materielId" name="materiel_id" required>
        <option value="">Sélectionnez un matériel</option>
        @foreach ($matriels as $materiel)
            <option value="{{ $materiel->id }}" @if($produit->materiel_id == $materiel->id) selected @endif>{{ $materiel->nom_materiel }}</option>
        @endforeach
    </select>
</div>
<div class="col-md-12">
    <label class="form-label" for="ticketObjet">nom du produit</label>
    <input class="form-control" id="produitnameedit" name="name" type="text"
        placeholder="Entrez l'e nom du produit" required value="{{ $produit->name }}">
</div>

<div class="col-md-12">
    <label class="form-label" for="ticketMessage">description</label>
    <textarea class="form-control" id="produitdescriptionedit" name="description" rows="3"
        placeholder="Entrez la description" required>{{ $produit->description }}</textarea>
</div>
<div class="col-md-12">
    <label class="form-label" for="materielImage">Prix</label>
    <input class="form-control" id="priceedit" name="price" type="number" value="{{ $produit->price }}" required>
</div>
<div class="col-md-12">
    <label class="form-label" for="materielImage">Image</label>
    <input class="form-control" id="materielImage" name="image" type="file" accept="image/*">
</div>
