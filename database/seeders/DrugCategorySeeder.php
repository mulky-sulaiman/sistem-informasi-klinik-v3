<?php

namespace Database\Seeders;

use App\Models\DrugCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DrugCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Analgesics' => 'Drugs that relieve pain. There are two main types : non-narcotic analgesics for mild pain, and narcotic analgesics for severe pain.',
            'Antacids' => 'Drugs that relieve indigestion and heartburn by neutralizing stomach acid.',
            'Antianxiety Drugs' => 'Drugs that suppress anxiety and relax muscles (sometimes called anxiolytics, sedatives, or minor tranquilizers).',
            'Antiarrhythmics' => 'Drugs used to control irregularities of heartbeat.',
            'Antibacterials' => 'Drugs used to treat infections.',
            'Antibiotics' => 'Drugs made from naturally occurring and synthetic substances that combat bacterial infection. Some antibiotics are effective only against limited types of bacteria. Others, known as broad spectrum antibiotics, are effective against a wide range of bacteria.',
            'Anticoagulants and Thrombolytics' => 'Anticoagulants prevent blood from clotting. Thrombolytics help dissolve and disperse blood clots and may be prescribed for patients with recent arterial or venous thrombosis.',
            'Anticonvulsants' => 'Drugs that prevent epileptic seizures.',
            'Antidepressants' => 'There are three main groups of mood-lifting antidepressants : tricyclics, monoamine oxidase inhibitors, and selective serotonin reuptake inhibitors (SSRIs).',
            'Antidiarrheals' => 'Drugs used for the relief of diarrhea. Two main types of antidiarrheal preparations are simple adsorbent substances and drugs that slow down the contractions of the bowel muscles so that the contents are propelled more slowly.',
            'Antiemetics' => 'Drugs used to treat nausea and vomiting.',
            'Antifungals' => 'Drugs used to treat fungal infections, the most common of which affect the hair, skin, nails, or mucous membranes.',
            'Antihistamines' => 'Drugs used primarily to counteract the effects of histamine, one of the chemicals involved in allergic reactions.',
            'Antihypertensives' => 'Drugs that lower blood pressure. The types of antihypertensives currently marketed include diuretics, beta-blockers, calcium channel blocker, ACE (angiotensin- converting enzyme) inhibitors, centrally acting antihypertensives and sympatholytics.',
            'Anti-Inflammatories' => 'Drugs used to reduce inflammation - the redness, heat, swelling, and increased blood flow found in infections and in many chronic noninfective diseases such as rheumatoid arthritis and gout.',
            'Antineoplastics' => 'Drugs used to treat cancer.',
            'Antipsychotics' => 'Drugs used to treat symptoms of severe psychiatric disorders. These drugs are sometimes called major tranquilizers.',
            'Antipyretics' => 'Drugs that reduce fever.',
            'Antivirals' => 'Drugs used to treat viral infections or to provide temporary protection against infections such as influenza.',
            'Barbiturates' => 'See "sleeping drugs."',
            'Beta-Blockers' => 'Beta-adrenergic blocking agents, or beta-blockers for short, reduce the oxygen needs of the heart by reducing heartbeat rate.',
            'Bronchodilators' => 'Drugs that open up the bronchial tubes within the lungs when the tubes have become narrowed by muscle spasm. Bronchodilators ease breathing in diseases such as asthma.',
            'Cold Cures' => 'Although there is no drug that can cure a cold, the aches, pains, and fever that accompany a cold can be relieved by aspirin or acetaminophen often accompanied by a decongestant, antihistamine, and sometimes caffeine.',
            'Corticosteroids' => 'These hormonal preparations are used primarily as anti-inflammatories in arthritis or asthma or as immunosuppressives, but they are also useful for treating some malignancies or compensating for a deficiency of natural hormones in disorders such as Addison\'s disease.',
            'Cough Suppressants' => 'Simple cough medicines, which contain substances such as honey, glycerine, or menthol, soothe throat irritation but do not actually suppress coughing. They are most soothing when taken as lozenges and dissolved in the mouth. As liquids they are probably swallowed too quickly to be effective. A few drugs are actually cough suppressants. There are two groups of cough suppressants : those that alter the consistency or production of phlegm such as mucolytics and expectorants; and those that suppress the coughing reflex such as codeine (narcotic cough suppressants), antihistamines, dextromethorphan and isoproterenol (non-narcotic cough suppressants).',
            'Cytotoxics' => 'Drugs that kill or damage cells. Cytotoxics are used as antineoplastics (drugs used to treat cancer) and also as immunosuppressives.',
            'Decongestants' => 'Drugs that reduce swelling of the mucous membranes that line the nose by constricting blood vessels, thus relieving nasal stuffiness.',
            'Diuretics' => 'Drugs that increase the quantity of urine produced by the kidneys and passed out of the body, thus ridding the body of excess fluid. Diuretics reduce water logging of the tissues caused by fluid retention in disorders of the heart, kidneys, and liver. They are useful in treating mild cases of high blood pressure.',
            'Expectorant' => 'A drug that stimulates the flow of saliva and promotes coughing to eliminate phlegm from the respiratory tract.',
            'Hormones' => 'Chemicals produced naturally by the endocrine glands (thyroid, adrenal, ovary, testis, pancreas, parathyroid). In some disorders, for example, diabetes mellitus, in which too little of a particular hormone is produced, synthetic equivalents or natural hormone extracts are prescribed to restore the deficiency. Such treatment is known as hormone replacement therapy.',
            'Hypoglycemics (Oral)' => 'Drugs that lower the level of glucose in the blood. Oral hypoglycemic drugs are used in diabetes mellitus if it cannot be controlled by diet alone, but does require treatment with injections of insulin.',
            'Immunosuppressives' => 'Drugs that prevent or reduce the body\'s normal reaction to invasion by disease or by foreign tissues. Immunosuppressives are used to treat autoimmune diseases (in which the body\'s defenses work abnormally and attack its own tissues) and to help prevent rejection of organ transplants.',
            'Laxatives' => 'Drugs that increase the frequency and ease of bowel movements, either by stimulating the bowel wall (stimulant laxative), by increasing the bulk of bowel contents (bulk laxative), or by lubricating them (stool-softeners, or bowel movement-softeners). Laxatives may be taken by mouth or directly into the lower bowel as suppositories or enemas. If laxatives are taken regularly, the bowels may ultimately become unable to work properly without them.',
            'Muscle Relaxants' => 'Drugs that relieve muscle spasm in disorders such as backache. Antianxiety drugs (minor tranquilizers) that also have a muscle-relaxant action are used most commonly.',
            'Sedatives' => 'Same as Antianxiety drugs.',
            'Sex Hormones (Female)' => 'There are two groups of these hormones (estrogens and progesterone), which are responsible for development of female secondary sexual characteristics. Small quantities are also produced in males. As drugs, female sex hormones are used to treat menstrual and menopausal disorders and are also used as oral contraceptives. Estrogens may be used to treat cancer of the breast or prostate, progestins (synthetic progesterone to treat endometriosis).',
            'Sex Hormones (Male)' => 'Androgenic hormones, of which the most powerful is testosterone, are responsible for development of male secondary sexual characteristics. Small quantities are also produced in females. As drugs, male sex hormones are given to compensate for hormonal deficiency in hypopituitarism or disorders of the testes. They may be used to treat breast cancer in women, but either synthetic derivatives called anabolic steroids, which have less marked side- effects, or specific anti-estrogens are often preferred. Anabolic steroids also have a "body building" effect that has led to their (usually nonsanctioned) use in competitive sports, for both men and women.',
            'Sleeping Drugs' => 'The two main groups of drugs that are used to induce sleep are benzodiazepines and barbiturates. All such drugs have a sedative effect in low doses and are effective sleeping medications in higher doses. Benzodiazepines drugs are used more widely than barbiturates because they are safer, the side-effects are less marked, and there is less risk of eventual physical dependence.',
            'Tranquilizer' => 'This is a term commonly used to describe any drug that has a calming or sedative effect. However, the drugs that are sometimes called minor tranquilizers should be called antianxiety drugs, and the drugs that are sometimes called major tranquilizers should be called antipsychotics.',
            'Vitamins' => 'Chemicals essential in small quantities for good health. Some vitamins are not manufactured by the body, but adequate quantities are present in a normal diet. People whose diets are inadequate or who have digestive tract or liver disorders may need to take supplementary vitamins.',
        ];

        foreach ($categories as $key => $value) {
            DrugCategory::factory()->create([
                'name' => $key,
                'description' => $value,
            ]);
        }
    }
}
