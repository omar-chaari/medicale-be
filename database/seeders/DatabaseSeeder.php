<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    header('Content-Type: text/html; charset=utf-8');

    DB::table('users')->delete();

    $html = '
    <select >
    <option value="13">Cardiologue</option>
    <option value="24">Chirurgien Esthétique</option>
    <option value="20">Chirurgien Orthopédiste Traumatologue</option>
    
      <option value="29">Dentiste</option>
      <option value="30">Dermatologue</option>
      <option value="33">Endocrinologue Diabétologue</option>
      <option value="35">Gastro-entérologue</option>
      <option value="36">Généraliste</option>
      <option value="39">Gynécologue Obstétricien</option>
      <option value="49">Interniste</option>
      <option value="62">Néphrologue</option>
      <option value="64">Neurologue</option>
      <option value="65">Nutritionniste</option>
      <option value="66">Ophtalmologiste</option>
      <option value="70">Oto-Rhino-Laryngologiste (ORL)</option>
      <option value="72">Pédiatre</option>
      <option value="78">Pneumologue</option>
      <option value="93">Psychiatre</option>
      <option value="94">Psychothérapeute</option>
      <option value="80">Radiologue</option>
      <option value="87">Rhumatologue</option>
      <option value="95">Sexologue</option>
      <option value="92">Urologue</option>

      <optgroup value="0" label="Autres spécialités">
        <option value="111">Acupuncture</option>
        <option value="120">Addictologue</option>
        <option value="121">Algologue</option>
        <option value="89">Allergologue</option>
        <option value="1">Anatomo-Cyto-Pathologiste</option>
        <option value="122">Andrologue</option>
        <option value="2">Anesthésiste-Réanimateur</option>
        <option value="3">Angiologue</option>
        <option value="160">Audiologiste</option>
        <option value="106">Audioprothésiste</option>
        <option value="172">Auriculothérapeute</option>
        <option value="6">Biochimiste</option>
        <option value="4">Biochimiste Clinique</option>
        <option value="5">Biologiste Medicale</option>
        <option value="10">Biophysique</option>
        <option value="12">Cancérologue</option>
        <option value="153">Centre d\'imagerie médicale</option>
        <option value="161">Chiropracteur</option>
        <option value="158">Chirurgie plastique et réparatrice</option>
        <option value="26">Chirurgien</option>
        <option value="14">Chirurgien Cancérologue</option>
        <option value="143">Chirurgien capillaire</option>
        <option value="15">Chirurgien Cardio-Vasculaire</option>
        <option value="16">Chirurgien Cardio-Vasculaire Thoracique</option>
        <option value="133">Chirurgien de l\'obésité</option>
        <option value="17">Chirurgien Généraliste</option>
        <option value="151">Chirurgien Maxillo Facial et Esthétique</option>
        <option value="91">Chirurgien Maxillo Facial Stomatologue</option>
        <option value="174">Chirurgien Orthopédiste Pédiatrique</option>
        <option value="21">Chirurgien Pédiatrique</option>
        <option value="22">Chirurgien Plasticien</option>
        <option value="27">Chirurgien Thoracique</option>
        <option value="25">Chirurgien Urologue</option>
        <option value="144">Chirurgien vasculaire</option>
        <option value="132">Chirurgien viscéral et digestif</option>
        <option value="31">Diabétologue</option>
        <option value="101">Diététicien</option>
        <option value="43">Embryologiste</option>
        <option value="32">Endocrinologue</option>
        <option value="150">Endodontiste</option>
        <option value="137">Epidemiologiste</option>
        <option value="142">Ergothérapeute</option>
        <option value="117">Généticien</option>
        <option value="102">Gériatre</option>
        <option value="41">Hématologue</option>
        <option value="42">Hématologue Clinique</option>
        <option value="7">Hématopathologiste</option>
        <option value="110">Hépatologue</option>
        <option value="116">Hypnothérapeute</option>
        <option value="44">Imagerie Médicale</option>
        <option value="45">Immunologiste</option>
        <option value="8">Immunopathologiste</option>
        <option value="152">Implantologue</option>
        <option value="149">Infirmier</option>
        <option value="50">Interniste Maladies Infectieuses</option>
        <option value="51">Interniste Réanimation Médicale</option>
        <option value="46">Kinésithérapeute</option>
        <option value="154">Laboratoire d\'analyses de biologie médicale</option>
        <option value="155">Laboratoire d\'anatomie et cytologie pathologiques</option>
        <option value="156">Laboratoire de cytogénétique</option>
        <option value="173">Maladies Cardiovasculaire</option>
        <option value="47">Maladies Infectieuses</option>
        <option value="59">Médecin Biologiste</option>
        <option value="162">Médecin de famille</option>
        <option value="168">Médecin du sommeil</option>
        <option value="118">Médecin du sport</option>
        <option value="48">Médecin du Travail</option>
        <option value="96">Médecin Esthétique</option>
        <option value="157">Médecin Hémodialyseur</option>
        <option value="123">Médecin homéopathe</option>
        <option value="52">Médecin Légiste</option>
        <option value="53">Médecin Nucléaire</option>
        <option value="55">Médecin Physique Réadaptateur</option>
        <option value="124">Médecin urgentiste</option>
        <option value="125">Médecine douce et alternative</option>
        <option value="126">Médecine morphologique et anti-âge</option>
        <option value="57">Médecine Préventive</option>
        <option value="146">Médecine tropicale</option>
        <option value="9">Microbiologiste</option>
        <option value="61">Néonatologiste</option>
        <option value="18">Neurochirurgien</option>
        <option value="171">Neuropédiatre</option>
        <option value="169">Neurophysiologiste</option>
        <option value="127">Neuropsychiatre</option>
        <option value="167">Neuropsychologue</option>
        <option value="159">Nutrithérapeute</option>
        <option value="164">Oncologue</option>
        <option value="145">Oncologue-Chimiothérapeute</option>
        <option value="85">Oncologue-Radiothérapeute</option>
        <option value="128">Opticien</option>
        <option value="67">Orthodontiste</option>
        <option value="100">Orthophoniste</option>
        <option value="104">Orthoptiste</option>
        <option value="115">Ostéopathe</option>
        <option value="71">Parasitologiste</option>
        <option value="119">Parodontiste implantologiste</option>
        <option value="74">Pédodontiste</option>
        <option value="73">Pédopsychiatre</option>
        <option value="166">Perineologue</option>
      
        <option value="108">Phlébologue</option>
        <option value="76">Physiologiste</option>
        <option value="99">Physiothérapeute</option>
        <option value="134">Phytothérapeute</option>
        <option value="107">Podologue</option>
        <option value="138">Posturologue</option>
        <option value="109">Proctologue</option>
        <option value="165">Prothésiste Capillaire</option>
        <option value="103">Prothésiste dentaire</option>
        <option value="113">Psychanalyste</option>
        <option value="79">Psychologue</option>
        <option value="170">Psychologue clinicien</option>
        <option value="112">Psychomotricien</option>
        <option value="84">Radiothérapeute</option>
        <option value="86">Réanimateur Médical</option>
        <option value="135">Réflexologue</option>
        <option value="130">Sage femme</option>
        <option value="131">Santé publique et médecine sociale</option>
        <option value="147">Sénologue</option>
        <option value="90">Stomatologue</option>
        <option value="148">Urodynamique</option>
        <option value="163">Vétérinaire</option>

  </select>
';

    // create a new DOMDocument and load the HTML
    $dom = new DOMDocument();
    
    $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

    // create a new DOMXPath object to query the DOM
    $xpath = new DOMXPath($dom);

    // find all option tags
    $options = $xpath->query('//option');

    // initialize an empty array to hold the results
    $result = array();




    // loop through the options and build the result array
    foreach ($options as $option) {
      $value = $option->getAttribute('value');
      $text = $option->textContent;
      $result[] = array('id' => (int)$value, 'speciality' => $text);
    }


 

    DB::table('specialities')->delete();
    DB::table('specialities')->insert($result);

    DB::table('governorates')->delete();
    DB::table('governorates')->insert(array(
      array('id' => 1, 'governorate' => 'Ariana'),
      array('id' => 2, 'governorate' => 'Beja'),
      array('id' => 3, 'governorate' => 'Ben arous'),
      array('id' => 4, 'governorate' => 'Bizerte'),
      array('id' => 5, 'governorate' => 'Gabes'),
      array('id' => 6, 'governorate' => 'Gafsa'),
      array('id' => 7, 'governorate' => 'Jendouba'),
      array('id' => 8, 'governorate' => 'Kairouan'),
      array('id' => 9, 'governorate' => 'Kasserine'),
      array('id' => 10, 'governorate' => 'Kebili'),
      array('id' => 11, 'governorate' => 'Le Kef'),
      array('id' => 12, 'governorate' => 'Mahdia'),
      array('id' => 13, 'governorate' => 'Mannouba'),
      array('id' => 14, 'governorate' => 'Medenine'),
      array('id' => 15, 'governorate' => 'Monastir'),
      array('id' => 16, 'governorate' => 'Nabeul'),
      array('id' => 17, 'governorate' => 'Sfax'),
      array('id' => 18, 'governorate' => 'Sidi bouzid'),
      array('id' => 19, 'governorate' => 'Siliana'),
      array('id' => 20, 'governorate' => 'Sousse'),
      array('id' => 21, 'governorate' => 'Tataouine'),
      array('id' => 22, 'governorate' => 'Tozeur'),
      array('id' => 23, 'governorate' => 'Tunis'),
      array('id' => 24, 'governorate' => 'Zaghouan'),
    ));

    DB::table('users')->delete();
    for ($i = 0; $i < 100; $i++) {
      $password = "testtest";
      $password = Hash::make($password);
      $first_name = $this->generateRandomTunisianFirstName();
      $last_name = $this->generateRandomTunisianLastName();
      $first_name_email=str_replace(' ', '', $first_name);
      $last_name_email=str_replace(' ', '', $last_name);

      $email = strtolower("$last_name_email-$first_name_email-$i@gmail.com");
      DB::table('users')->insert(array(
        array(
          'email' => $email, 'password' => "$password",
          "first_name" => $first_name, "last_name" => $last_name, "speciality" => $this->generatespeciality(),
          "governorate" => $this->generateGovernorate(), "address" => $this->generateRandomAddress(), "phone" => $this->generateRandomPhone(),
          "verification" => 1
        ),

      ));
    }
  }
  function generateRandomAddress()
  {
    $streets = array(
      "Rue de la Liberté",
      "Avenue Habib Bourguiba",
      "Boulevard Mohamed V",
      "Rue Ibn Khaldoun",
      "Avenue de Carthage",
      "Boulevard 14 Janvier",
      "Rue Farhat Hached",
      "Avenue du Président Habib Bourguiba",
      "Rue du 2 Mars",
      "Boulevard de la République"
    );
    $number = rand(1, 120);
    $street = $streets[rand(0, count($streets) - 1)];

    return "$number $street";
  }
  function generateRandomPhone()
  {
    $prefixes = array("20", "21", "22", "23", "24", "25", "26", "27", "28", "29");
    $prefix = $prefixes[rand(0, count($prefixes) - 1)];
    $number = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    return "$prefix$number";
  }

  function generatespeciality()
  {
    $prefixes = array(13, 24, 20);
    $prefix = $prefixes[rand(0, count($prefixes) - 1)];
    return $prefix;
  }
  function generateGovernorate()
  {
    $prefixes = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
    $prefix = $prefixes[rand(0, count($prefixes) - 1)];
    return $prefix;
  }

  function generateRandomTunisianFirstName()
  {
    $firstNames = array(
      "Amine", "Fatma", "Mohamed", "Samia", "Ahmed",
      "Saida", "Zied", "Rania", "Riadh", "Mouna",
      "Karim", "Nadia", "Hassan", "Noura", "Sami",
      "Imen", "Wassim", "Khalil", "Dorsaf", "Chokri",
      "Yosra", "Marwen", "Salma", "Jamel", "Rim"
    );

    $firstName = $firstNames[array_rand($firstNames)];

    return $firstName;
  }

  function generateRandomTunisianLastName()
  {
    $lastNames = array(
      "Ben Ali", "Ben Amor", "Ben Hassen", "Ben Mahmoud", "Bouhlel",
      "Bouzid", "Chaabane", "Gharbi", "Haddad", "Hamdi",
      "Jemmali", "Kamoun", "Khelifi", "Mahjoub", "Messaoudi",
      "Miled", "Naceur", "Rahmouni", "Rebai", "Sahli",
      "Sfaxi", "Soltani", "Trabelsi", "Zaier", "Zidi"
    );

    $lastName = $lastNames[array_rand($lastNames)];

    return $lastName;
  }
}
