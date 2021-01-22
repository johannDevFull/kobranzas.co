<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'historial.index']);
        Permission::create(['name' => 'historial.show']);
        Permission::create(['name' => 'chat.index']);
        Permission::create(['name' => 'conjuntos.export']);
        Permission::create(['name' => 'clients.import']);
        //Permission Admin 
        Permission::create(['name' => 'user.index']);
        Permission::create(['name' => 'user.edit']);
        Permission::create(['name' => 'user.show']);
        Permission::create(['name' => 'user.create']);
        Permission::create(['name' => 'user.destroy']);

        Permission::create(['name' => 'perfil.edit']);
        // *****

        //Permission Cliente 
        Permission::create(['name' => 'statement.client']);
        // *****

        //Permission Empleado
        Permission::create(['name' => 'empleado.index']);
        Permission::create(['name' => 'empleado.edit']);
        Permission::create(['name' => 'empleado.show']);
        Permission::create(['name' => 'empleado.create']);
        // *****

        //Permission AdministradorConjunto
        Permission::create(['name' => 'administrador.index']);
        Permission::create(['name' => 'administrador.show']);
        Permission::create(['name' => 'clients.index']);
        Permission::create(['name' => 'clients.show']);
        Permission::create(['name' => 'statement.details']);

        // *****

        //Crear roles
        $admin = Role::create(['name' => 'Admin']);
        $cliente = Role::create(['name' => 'Cliente']);
        $empleado = Role::create(['name' => 'Empleado']);
        $administrador = Role::create(['name' => 'AdminConjunto']);
        // *****


        //Asignar permisos Admin
        $admin->givePermissionTo([
            'user.index',
            'user.edit',
            'user.show',
            'user.create',
            'user.destroy',
            'chat.index',
            'conjuntos.export',
            'clients.import',
            'historial.index',
            'historial.show',
            'clients.index',
            'clients.show',
            'statement.details'
        ]);
        // *****

        //Asignar permisos Cliente
        $cliente->givePermissionTo([
            'statement.client',
            
        ]);
        // *****

        //Asignar permisos Empleado
        $empleado->givePermissionTo([
            'chat.index',
            'user.index',
            'user.edit',
            'user.show',
            'user.create'
        ]);
        // *****

        //Asignar permisos AdministradorConjuntos
        $administrador->givePermissionTo([
            'chat.index',
            'user.index',
            'user.show',
            'clients.index',
            'clients.show',
            'statement.details'
        ]);
        // *****

        //User Admin
        $user = User::find(1);
        $user->assignRole('Admin');

        //User Cliente
        $user2 = User::find(2);
        $user2->assignRole('Cliente');

        //User Empleado
        $user3 = User::find(3);
        $user3->assignRole('Empleado');

        //User Administrador
        $user4 = User::find(4);
        $user4->assignRole('AdminConjunto');

        $users = User::all();
 
        $tamano=sizeof($users);
        for ($i=4; $i < $tamano ; $i++) 
        { 
            $usuario = User::find($users[$i]->id); 
            $usuario->assignRole('Cliente');   
        }

        $usuarioAdminConjunto = User::find($tamano); 
        $usuarioAdminConjunto->assignRole('AdminConjunto'); 

 
    }
}
