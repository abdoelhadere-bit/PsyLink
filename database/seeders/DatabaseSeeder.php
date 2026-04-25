<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Professional;
use App\Models\Association;
use App\Models\Appointment;
use App\Models\Review;
use App\Models\Activity;
use App\Models\Participation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        User::create([
            'name' => 'Super Administrateur',
            'email' => 'admin@psylink.com',
            'password' => Hash::make('admin@psylink.com'),
            'role' => 'admin',
            'city' => 'Casablanca',
        ]);

        $patients = [];
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => 'Patient ' . $i,
                'email' => "patient{$i}@psylink.com",
                'password' => Hash::make("patient{$i}@psylink.com"),
                'role' => 'patient',
                'city' => ['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger'][array_rand(['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger'])],
            ]);
            $patients[] = Patient::create(['user_id' => $user->id, 'credits' => rand(0, 3)]);
        }

        $pros = [];
        $specialties = ['Psychologue Clinicien', 'Psychiatre', 'Thérapeute TCC'];
        $bios = [
            "Spécialiste en thérapies cognitivo-comportementales, j'accompagne mes patients dans la gestion du stress, de l'anxiété et des troubles dépressifs depuis plus de 10 ans.",
            "Psychiatre diplômé, je propose des consultations en ligne pour aider les personnes souffrant de troubles de l'humeur, d'insomnie ou de burn-out professionnel.",
            "Thérapeute certifié TCC, mon approche est centrée sur le patient. Je travaille sur la restructuration cognitive et l'amélioration du bien-être au quotidien.",
            "Psychologue clinicien passionné par la santé mentale, j'aide mes patients à traverser les moments difficiles avec bienveillance et professionnalisme.",
            "Spécialisée dans les troubles anxieux et phobiques, j'utilise des techniques modernes de pleine conscience et d'exposition progressive pour vous accompagner.",
        ];

        $specialRealPros = [
            [
                'name' => 'Alice Bernard',
                'email' => 'alice.b@gmail.com',
                'specialty' => 'Psychologue Clinicienne',
                'bio' => 'Spécialiste en thérapies cognitivo-comportementales, j\'accompagne mes patients dans la gestion du stress, de l\'anxiété et des troubles dépressifs.',
            ],
            [
                'name' => 'Marc Thomas',
                'email' => 'marc.t@gmail.com',
                'specialty' => 'Psychiatre',
                'bio' => 'Psychiatre diplômé, je propose des consultations en ligne pour aider les personnes souffrant de troubles de l\'humeur et d\'insomnie.',
            ],
            [
                'name' => 'Chloé Martin',
                'email' => 'chloe.m@gmail.com',
                'specialty' => 'Thérapeute TCC',
                'bio' => 'Thérapeute certifié TCC, mon approche est centrée sur le patient. Je travaille sur la restructuration cognitive et l\'amélioration du bien-être.',
            ],
        ];

        foreach ($specialRealPros as $idx => $proData) {
            $user = User::create([
                'name' => $proData['name'],
                'email' => $proData['email'],
                'password' => Hash::make('password'),
                'role' => 'professional',
                'city' => ['Casablanca', 'Rabat', 'Marrakech'][rand(0, 2)],
                'bio' => $proData['bio'],
            ]);
            $pros[] = Professional::create([
                'user_id' => $user->id,
                'specialty' => $proData['specialty'],
                'is_valid' => true,
                'hourly_rate' => [60, 80, 60][$idx],
            ]);
        }

        // Compléter avec quelques autres pros si besoin
        for ($i = 4; $i <= 6; $i++) {
            $user = User::create([
                'name' => 'Professionnel ' . $i,
                'email' => "pro{$i}@psylink.com",
                'password' => Hash::make("pro{$i}@psylink.com"),
                'role' => 'professional',
                'city' => ['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger'][array_rand(['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger'])],
                'bio' => $bios[array_rand($bios)],
            ]);
            $pros[] = Professional::create([
                'user_id' => $user->id,
                'specialty' => $specialties[array_rand($specialties)],
                'is_valid' => true,
                'hourly_rate' => rand(8, 16) * 5,
            ]);
        }

        // Associations
        $assocData = [
            ['name' => 'Esprit Sain Maroc', 'description' => 'Association dédiée à la sensibilisation sur la santé mentale au Maroc. Nous organisons des ateliers gratuits pour les personnes en situation de précarité.'],
            ['name' => 'Solidarité Psy', 'description' => 'Nous mettons en relation des professionnels bénévoles avec des publics défavorisés pour rendre la thérapie accessible à tous.'],
            ['name' => 'Équilibre & Bien-Être', 'description' => 'Association spécialisée dans la prévention du burn-out et du stress professionnel. Ateliers, groupes de parole et consultations solidaires.'],
        ];
        $associations = [];
        for ($i = 0; $i < 3; $i++) {
            $user = User::create([
                'name' => $assocData[$i]['name'],
                'email' => "assoc" . ($i + 1) . "@psylink.com",
                'password' => Hash::make("assoc" . ($i + 1) . "@psylink.com"),
                'role' => 'association',
                'city' => ['Casablanca', 'Rabat', 'Marrakech'][array_rand(['Casablanca', 'Rabat', 'Marrakech'])],
            ]);
            $associations[] = Association::create([
                'user_id' => $user->id,
                'description' => $assocData[$i]['description'],
            ]);
        }

        // Activités solidaires — Missions de bénévolat terrain
        $activitiesData = [
            [
                'title'       => 'Soutien scolaire — École primaire Al Amal',
                'description' => 'Accompagnement d\'enfants en difficulté scolaire dans une école primaire de quartier défavorisé. Activités de lecture, mathématiques et éveil artistique. Aucune compétence particulière requise, juste de la bienveillance.',
                'type'        => 'benevole_ecole',
                'city'        => 'Casablanca',
                'days'        => 5, 'max' => 8, 'credits' => 1,
            ],
            [
                'title'       => 'Animation à l\'orphelinat Dar Al Rahma',
                'description' => 'Journée d\'animation avec les enfants de l\'orphelinat : jeux, activités manuelles et accompagnement affectif. Une expérience humaine profonde qui contribue au bien-être des enfants vulnérables.',
                'type'        => 'benevole_orphelinat',
                'city'        => 'Rabat',
                'days'        => 7, 'max' => 10, 'credits' => 2,
            ],
            [
                'title'       => 'Visite aux personnes âgées — Maison de repos Assalam',
                'description' => 'Rendez-vous hebdomadaire avec les résidents de la maison de repos : conversations, lecture à voix haute, jeux de société. Lutte contre l\'isolement des personnes âgées.',
                'type'        => 'benevole_maison_repos',
                'city'        => 'Marrakech',
                'days'        => 10, 'max' => 6, 'credits' => 1,
            ],
            [
                'title'       => 'Accompagnement Centre Handicap Al Amal',
                'description' => 'Aide aux activités quotidiennes et aux ateliers créatifs pour les personnes en situation de handicap. Formation courte fournie sur place par l\'équipe éducative du centre.',
                'type'        => 'benevole_handicap',
                'city'        => 'Fès',
                'days'        => 14, 'max' => 5, 'credits' => 2,
            ],
            [
                'title'       => 'Aide aux devoirs — Collège Ibn Khaldoun',
                'description' => 'Séances de soutien scolaire pour des collégiens en difficulté. Les bénévoles aident sur les matières de leur choix (français, maths, sciences). Engagement sur 3 séances minimum.',
                'type'        => 'benevole_ecole',
                'city'        => 'Tanger',
                'days'        => 12, 'max' => 12, 'credits' => 1,
            ],
            [
                'title'       => 'Distribution alimentaire — Quartier Hay Mohammadi',
                'description' => 'Participation à la collecte et distribution de repas pour les familles en situation de précarité, en partenariat avec les associations locales du quartier.',
                'type'        => 'benevole_social',
                'city'        => 'Casablanca',
                'days'        => 3, 'max' => 20, 'credits' => 1,
            ],
        ];

        $activities = [];
        foreach ($activitiesData as $idx => $data) {
            $assoc = $associations[$idx % count($associations)];
            $activities[] = Activity::create([
                'association_id'       => $assoc->id,
                'title'                => $data['title'],
                'description'          => $data['description'],
                'type'                 => $data['type'],
                'city'                 => $data['city'] ?? null,
                'scheduled_at'         => Carbon::now()->addDays($data['days'])->setHour(10)->setMinute(0),
                'max_participants'     => $data['max'],
                'available_places'     => $data['max'],
                'free_sessions_earned' => $data['credits'],
            ]);
        }

        // Rendez-vous aléatoires
        $statuses = ['pending', 'accepted', 'waiting_payment', 'paid', 'completed'];
        for ($i = 1; $i <= 20; $i++) {
            $pro = $pros[array_rand($pros)];
            $patient = $patients[array_rand($patients)];
            $status = $statuses[array_rand($statuses)];
            $daysOffset = rand(-15, 15);

            $appointment = Appointment::create([
                'patient_id'       => $patient->id,
                'professional_id'  => $pro->id,
                'type'             => rand(0, 1) ? 'video' : 'chat',
                'status'           => $status,
                'scheduled_at'     => Carbon::now()->addDays($daysOffset)->setHour(rand(9, 17))->setMinute(0),
                'duration_minutes' => 60,
                'price'            => $pro->hourly_rate,
            ]);

            if ($status === 'completed' || $status === 'paid') {
                if (rand(1, 100) > 30) {
                    Review::create([
                        'appointment_id' => $appointment->id,
                        'rating'         => rand(3, 5),
                        'comment'        => "Excellente séance, praticien très professionnel et à l'écoute.",
                    ]);
                }
            }
        }

        // Données garanties pour patient1
        Appointment::create([
            'patient_id'       => $patients[0]->id,
            'professional_id'  => $pros[0]->id,
            'type'             => 'video',
            'status'           => 'paid',
            'scheduled_at'     => Carbon::now()->addHours(2),
            'duration_minutes' => 60,
            'price'            => $pros[0]->hourly_rate,
        ]);

        Appointment::create([
            'patient_id'       => $patients[0]->id,
            'professional_id'  => $pros[1]->id,
            'type'             => 'video',
            'status'           => 'waiting_payment',
            'scheduled_at'     => Carbon::now()->addDays(1)->setHour(10)->setMinute(0),
            'duration_minutes' => 60,
            'price'            => $pros[1]->hourly_rate,
        ]);

        // Participations garanties pour patient1
        Participation::create([
            'patient_id'   => $patients[0]->id,
            'activity_id'  => $activities[0]->id,
            'status'       => 'accepted',
            'is_validated' => true,
        ]);
        Participation::create([
            'patient_id'   => $patients[0]->id,
            'activity_id'  => $activities[1]->id,
            'status'       => 'pending',
            'is_validated' => false,
        ]);
        Participation::create([
            'patient_id'   => $patients[0]->id,
            'activity_id'  => $activities[2]->id,
            'status'       => 'attended',
            'is_validated' => true,
        ]);

        // Participations aléatoires pour les autres patients
        for ($i = 1; $i < count($patients); $i++) {
            if (rand(0, 1)) {
                $activity = $activities[array_rand($activities)];
                Participation::create([
                    'patient_id'   => $patients[$i]->id,
                    'activity_id'  => $activity->id,
                    'status'       => ['pending', 'accepted'][array_rand(['pending', 'accepted'])],
                    'is_validated' => false,
                ]);
            }
        }

        // --- PATIENT SPÉCIAL POUR DÉMO VIDÉO ---
        $demoUser = User::create([
            'name'     => 'Sarah Demo',
            'email'    => 'demo@psylink.com',
            'password' => Hash::make('demo@psylink.com'),
            'role'     => 'patient',
            'city'     => 'Casablanca',
            'phone'    => '0612345678',
        ]);
        $demoPatient = Patient::create([
            'user_id' => $demoUser->id, 
            'credits' => 2,
            'gender'   => 'female',
            'birth_date' => '1995-05-15',
        ]);

        $demoAssocUser = User::create([
            'name'     => 'Association Espoir',
            'email'    => 'espoir@psylink.com',
            'password' => Hash::make('espoir@psylink.com'),
            'role'     => 'association',
            'city'     => 'Rabat',
        ]);
        $demoAssoc = Association::create([
            'user_id'     => $demoAssocUser->id,
            'description' => 'Association de test pour la validation des missions solidaires.',
        ]);

        $demoActivity = Activity::create([
            'association_id'       => $demoAssoc->id,
            'title'                => 'Mission Sensibilisation (Démo)',
            'description'          => 'Une mission passionnante en attente de validation pour Sarah.',
            'type'                 => 'benevole_social',
            'city'                 => 'Casablanca',
            'scheduled_at'         => Carbon::now()->subDays(2),
            'max_participants'     => 10,
            'available_places'     => 10,
            'free_sessions_earned' => 1,
        ]);

        // Participations pour Sarah
        Participation::create([
            'patient_id'   => $demoPatient->id,
            'activity_id'  => $demoActivity->id,
            'status'       => 'attended',
            'is_validated' => false, // En attente de validation par l'association
        ]);

        Participation::create([
            'patient_id'   => $demoPatient->id,
            'activity_id'  => $activities[0]->id,
            'status'       => 'attended',
            'is_validated' => true, // Déjà validé
        ]);

        // Rendez-vous pour Sarah
        Appointment::create([
            'patient_id'       => $demoPatient->id,
            'professional_id'  => $pros[0]->id,
            'type'             => 'video',
            'status'           => 'completed',
            'scheduled_at'     => Carbon::now()->subDays(5),
            'duration_minutes' => 60,
            'price'            => 60,
        ]);

        Appointment::create([
            'patient_id'       => $demoPatient->id,
            'professional_id'  => $pros[1]->id,
            'type'             => 'video',
            'status'           => 'paid',
            'scheduled_at'     => Carbon::now()->addDays(2)->setHour(14),
            'duration_minutes' => 60,
            'price'            => 80,
        ]);

        // Séance qui démarre TOUT DE SUITE (pour tester le bouton "Lancer la séance")
        Appointment::create([
            'patient_id'       => $demoPatient->id,
            'professional_id'  => $pros[2]->id, // Chloé Martin
            'type'             => 'video',
            'status'           => 'paid',
            'scheduled_at'     => Carbon::now()->subMinutes(2), // Déjà commencée depuis 2 min
            'duration_minutes' => 60,
            'price'            => 60,
        ]);

        // Séance en attente de paiement (pour montrer le flux de paiement)
        Appointment::create([
            'patient_id'       => $demoPatient->id,
            'professional_id'  => $pros[0]->id,
            'type'             => 'video',
            'status'           => 'waiting_payment',
            'scheduled_at'     => Carbon::now()->addDays(3)->setHour(10),
            'duration_minutes' => 60,
            'price'            => 60,
        ]);
    }
}
