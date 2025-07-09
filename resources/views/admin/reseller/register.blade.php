<div class="mb-4">
    <label for="level" class="block text-gray-700 font-bold mb-2">Level</label>
    <select name="level" id="level" class="form-control">
        <option value="gold" {{ old('level') == 'gold' ? 'selected' : '' }}>Gold</option>
        <option value="platinum" {{ old('level') == 'platinum' ? 'selected' : '' }}>Platinum</option>
    </select>
</div> 