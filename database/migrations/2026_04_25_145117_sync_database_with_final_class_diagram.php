<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Nettoyage de la table USERS
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('photo');
            }
            if (Schema::hasColumn('users', 'birth_date')) {
                $table->dropColumn('birth_date');
            }
            if (Schema::hasColumn('users', 'gender')) {
                $table->dropColumn('gender');
            }
        });

        // 2. Nettoyage de la table PATIENTS
        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'birth_date')) {
                $table->date('birth_date')->nullable()->after('credits');
            }
            if (!Schema::hasColumn('patients', 'gender')) {
                $table->string('gender')->nullable()->after('birth_date');
            }
            if (Schema::hasColumn('patients', 'bio')) {
                $table->dropColumn('bio');
            }
        });

        // 3. Nettoyage de la table PROFESSIONALS
        Schema::table('professionals', function (Blueprint $table) {
            if (Schema::hasColumn('professionals', 'bio')) {
                $table->dropColumn('bio');
            }
        });

        // 4. Nettoyage de la table ASSOCIATIONS
        Schema::table('associations', function (Blueprint $table) {
            if (Schema::hasColumn('associations', 'name')) {
                $table->dropColumn('name');
            }
        });

        // 5. Nettoyage de la table ACTIVITIES
        Schema::table('activities', function (Blueprint $table) {
            if (!Schema::hasColumn('activities', 'available_places')) {
                $table->integer('available_places')->after('max_participants');
            }
        });

        // 6. Nettoyage de la table APPOINTMENTS
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'topic')) {
                $table->dropColumn('topic');
            }
            if (Schema::hasColumn('appointments', 'notes')) {
                $table->dropColumn('notes');
            }
        });

        // 7. Nettoyage de la table REVIEWS (Suppression de la redondance)
        Schema::table('reviews', function (Blueprint $table) {
            if (Schema::hasColumn('reviews', 'reviewer_id')) {
                $table->dropForeign(['reviewer_id']);
                $table->dropColumn('reviewer_id');
            }
        });
    }

    public function down(): void
    {
        // Inverse logic with checks for rollback safety
        Schema::table('reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('reviews', 'reviewer_id')) {
                $table->foreignId('reviewer_id')->nullable()->constrained('users');
            }
        });

        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'topic')) {
                $table->string('topic')->nullable();
            }
            if (!Schema::hasColumn('appointments', 'notes')) {
                $table->text('notes')->nullable();
            }
        });

        Schema::table('activities', function (Blueprint $table) {
            if (Schema::hasColumn('activities', 'available_places')) {
                $table->dropColumn('available_places');
            }
        });

        Schema::table('associations', function (Blueprint $table) {
            if (!Schema::hasColumn('associations', 'name')) {
                $table->string('name')->nullable();
            }
        });

        Schema::table('professionals', function (Blueprint $table) {
            if (!Schema::hasColumn('professionals', 'bio')) {
                $table->text('bio')->nullable();
            }
        });

        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'bio')) {
                $table->text('bio')->nullable();
            }
            if (Schema::hasColumn('patients', 'birth_date')) {
                $table->dropColumn('birth_date');
            }
            if (Schema::hasColumn('patients', 'gender')) {
                $table->dropColumn('gender');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'bio')) {
                $table->dropColumn('bio');
            }
            if (!Schema::hasColumn('users', 'birth_date')) {
                $table->date('birth_date')->nullable();
            }
            if (!Schema::hasColumn('users', 'gender')) {
                $table->string('gender')->nullable();
            }
        });
    }
};
