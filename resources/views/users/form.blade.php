<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold mb-6">{{ isset($user) ? 'Edit User' : 'Create User' }}</h2>
    
    <form action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}" method="POST">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 mb-2">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" 
                   class="w-full px-3 py-2 border rounded" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="email" class="block text-gray-700 mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" 
                   class="w-full px-3 py-2 border rounded" required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        @if(!isset($user))
        <div class="mb-4">
            <label for="password" class="block text-gray-700 mb-2">Password</label>
            <input type="password" name="password" id="password" 
                   class="w-full px-3 py-2 border rounded" required>
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        @endif
        
        <div class="mb-6">
            <label for="role_id" class="block text-gray-700 mb-2">Role</label>
            <select name="role_id" id="role_id" class="w-full px-3 py-2 border rounded" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" 
                        {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            {{ isset($user) ? 'Update User' : 'Create User' }}
        </button>
    </form>
</div>