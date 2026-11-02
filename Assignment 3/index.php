<?php
/* ============================================================
 * Assignment - كل المسائل (1 → 12) في ملف واحد
 * كل مسألة: رقمها + نص المسألة + الحل
 * ============================================================ */

/* دوال مساعدة لعرض كل مسألة في كارت مرقّم */
function startProblem(int $n, string $name): void
{
    echo "<div class='card'><h3>المسألة $n — $name</h3><pre>";
}
function endProblem(): void
{
    echo "</pre></div>";
}
function e(string $s): string   // حماية من XSS
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

/* معالجة فورم مسألة 12 (لازم قبل أي طباعة عشان نجهز النتيجة) */
$errors = [];
$result = null;
$price = $quantity = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $price    = trim($_POST['price'] ?? '');
    $quantity = trim($_POST['quantity'] ?? '');

    if ($price === '') {
        $errors[] = "من فضلك أدخل سعر المنتج.";
    } elseif (!is_numeric($price)) {
        $errors[] = "سعر المنتج لازم يكون رقم (مينفعش حروف).";
    } elseif ($price < 0) {
        $errors[] = "سعر المنتج مينفعش يكون رقم سالب.";
    } elseif ($price == 0) {
        $errors[] = "سعر المنتج لازم يكون أكبر من صفر.";
    }

    if ($quantity === '') {
        $errors[] = "من فضلك أدخل عدد القطع.";
    } elseif (!is_numeric($quantity)) {
        $errors[] = "عدد القطع لازم يكون رقم (مينفعش حروف).";
    } elseif ($quantity < 0) {
        $errors[] = "عدد القطع مينفعش يكون رقم سالب.";
    } elseif ($quantity == 0) {
        $errors[] = "عدد القطع لازم يكون واحد على الأقل.";
    } elseif (floor($quantity) != $quantity) {
        $errors[] = "عدد القطع لازم يكون رقم صحيح (مينفعش كسور).";
    }

    if (empty($errors)) {
        $total    = (float)$price * (int)$quantity;
        $rate     = ($total > 1000) ? 0.15 : 0.10;   // أكبر من 1000 => 15% ، غير كده 10%
        $discount = $total * $rate;
        $result   = [
            'total'    => $total,
            'rate'     => $rate * 100,
            'discount' => $discount,
            'final'    => $total - $discount,
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Assignment - كل المسائل</title>
<style>
    body { font-family: Tahoma, Arial, sans-serif; background:#f4f6f8; max-width:760px; margin:30px auto; padding:0 12px; }
    h1 { text-align:center; }
    .card { background:#fff; padding:16px 22px; border-radius:12px; margin-bottom:16px; box-shadow:0 2px 10px rgba(0,0,0,.07); }
    .card h3 { margin:0 0 10px; color:#1d4ed8; }
    pre { margin:0; font-size:15px; white-space:pre-wrap; unicode-bidi:plaintext; text-align:start; }
    label { display:block; margin:12px 0 6px; font-weight:bold; }
    input[type=text] { width:100%; padding:10px; border:1px solid #ccc; border-radius:8px; box-sizing:border-box; }
    button { margin-top:16px; width:100%; padding:11px; border:0; border-radius:8px; background:#2563eb; color:#fff; font-size:16px; cursor:pointer; }
    .error  { background:#fee2e2; color:#991b1b; padding:10px 14px; border-radius:8px; margin-top:14px; }
    .result { background:#dcfce7; color:#14532d; padding:14px; border-radius:8px; margin-top:14px; line-height:2; }
</style>
</head>
<body>
<h1>Assignment — حلول المسائل (1 → 12)</h1>

<?php
/* ============================================================
 * المسألة 1 (if, else)
 * ------------------------------------------------------------
 * اعمل task بتعمل check على الـ age للمستخدم للموافقة على تسجيل الدخول:
 *   - لو age 18 أو أكتر => اطبع رسالة بالموافقة على تسجيل الدخول في الموقع
 *   - لو أقل من 18      => اطبع رسالة بعدم الموافقة
 * ============================================================ */
startProblem(1, "if / else");

$age = 20;   // غيّر القيمة للتجربة

if ($age >= 18) {
    echo "تمت الموافقة على تسجيل الدخول في الموقع";
} else {
    echo "عذرًا، غير مسموح لك بتسجيل الدخول (السن أقل من 18)";
}
endProblem();


/* ============================================================
 * المسألة 2 (function)
 * ------------------------------------------------------------
 * اعمل فانكشن بتاخد 2 parameter (رقمين)
 * واطبع حاصل ضربهم والفرق بينهم وخارج القسمة.
 * ============================================================ */
startProblem(2, "function");

function calculate($a, $b)
{
    echo "الضرب       : " . ($a * $b) . "\n";
    echo "الفرق       : " . ($a - $b) . "\n";

    if ($b == 0) {   // حماية من القسمة على صفر
        echo "خارج القسمة : مينفعش القسمة على صفر";
    } else {
        echo "خارج القسمة : " . ($a / $b);
    }
}

calculate(20, 4);
endProblem();


/* ============================================================
 * المسألة 3 (function with array)
 * ------------------------------------------------------------
 * هتعمل فانكشن بتاخد array من الأرقام وبترجع مجموعهم.
 * ============================================================ */
startProblem(3, "function with array");

function sumArray(array $numbers)
{
    $sum = 0;
    foreach ($numbers as $n) {
        $sum += $n;
    }
    return $sum;
    // البديل الجاهز: return array_sum($numbers);
}

echo "المجموع = " . sumArray([1, 2, 3, 4, 5]);
endProblem();


/* ============================================================
 * المسألة 4 (search) — زي بتاعة السيشن بالظبط
 * ------------------------------------------------------------
 * معاك array من أسامي الأفلام وهتدور على فيلم جواه.
 *   $films = array("Fast","Predestination","Persuit","Prestige");
 *   $keyword = "avatar";
 * النتيجة هتكون yes / no
 * وأول ما تلاقي الفيلم اخرج من اللوب.
 * ============================================================ */
startProblem(4, "search");

$films   = array("Fast", "Predestination", "Persuit", "Prestige");
$keyword = "avatar";
$found   = false;

foreach ($films as $film) {
    if (strcasecmp($film, $keyword) === 0) {
        $found = true;
        break;   // أول ما نلاقيه نخرج من اللوب
    }
}

echo $found ? "yes" : "no";
endProblem();


/* ============================================================
 * المسألة 5 (Bubble Sort)
 * ------------------------------------------------------------
 * (اقرأ اللينك بتاع w3schools عن Bubble Sort)
 * هتعمل فانكشن بترتب أي array بيجيلها بـ Bubble Sort
 * هتسميها RouteBubble
 * ============================================================ */
startProblem(5, "RouteBubble (Bubble Sort)");

function RouteBubble(array $arr): array
{
    $n = count($arr);

    for ($i = 0; $i < $n - 1; $i++) {
        $swapped = false;

        for ($j = 0; $j < $n - $i - 1; $j++) {
            if ($arr[$j] > $arr[$j + 1]) {          // لو اللي قبل أكبر نبدّلهم
                $temp        = $arr[$j];
                $arr[$j]     = $arr[$j + 1];
                $arr[$j + 1] = $temp;
                $swapped     = true;
            }
        }

        if (!$swapped) {   // لو مفيش تبديل يبقى الترتيب خلص
            break;
        }
    }
    return $arr;
}

echo implode(" ", RouteBubble([64, 34, 25, 12, 22, 11, 90]));
endProblem();


/* ============================================================
 * المسألة 6 (max)
 * ------------------------------------------------------------
 * معاك array من الأرقام وعايزك تجيب أكبر رقم موجود جوه الـ array.
 *   Input : $tests = array(5,4,9,3,1,7,5,8,6);
 *   Output: 9
 * ============================================================ */
startProblem(6, "max");

$tests = array(5, 4, 9, 3, 1, 7, 5, 8, 6);

$max = $tests[0];
foreach ($tests as $value) {
    if ($value > $max) {
        $max = $value;
    }
}
echo $max;   // 9
// البديل الجاهز: echo max($tests);
endProblem();


/* ============================================================
 * المسألة 7 (counting)
 * ------------------------------------------------------------
 * معاك array من الأفلام المتكررة، هتقولي الفيلم متكرر كام مرة.
 *   $films = array("avatar","Prestige","avatar","Prestige");
 *   $keyword = "avatar";
 * النتيجة هتكون 2
 * ============================================================ */
startProblem(7, "counting");

$films   = array("avatar", "Prestige", "avatar", "Prestige");
$keyword = "avatar";
$count   = 0;

foreach ($films as $film) {
    if ($film === $keyword) {
        $count++;
    }
}
echo $count;   // 2
// البديل الجاهز: echo count(array_keys($films, $keyword));
endProblem();


/* ============================================================
 * المسألة 8 (RouteRandomPass)
 * ------------------------------------------------------------
 * (اقرأ لينك geeksforgeeks عن Generating random string using PHP)
 * فانكشن RouteRandomPass: هتبعتلها رقم وهترجعلك كلمة عشوائية
 * عدد حروفها = الرقم ده.
 * ============================================================ */
startProblem(8, "RouteRandomPass");

function RouteRandomPass(int $length): string
{
    if ($length <= 0) {
        return "";
    }

    $chars  = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $maxIdx = strlen($chars) - 1;
    $result = "";

    for ($i = 0; $i < $length; $i++) {
        $result .= $chars[random_int(0, $maxIdx)];
    }
    return $result;
}

echo RouteRandomPass(10);
endProblem();


/* ============================================================
 * المسألة 9 (Boolean)
 * ------------------------------------------------------------
 * معاك array من أنواع مختلفة. اعرض أي داتا معادا الـ Boolean
 * زي ما هي، والـ Boolean اعرضه بشكل Yes / No.
 *   $tests = array(1,"tariq",1.5,true,7,'s',false);
 * اعمله مرة بالـ for ومرة بالـ while.
 * ============================================================ */
startProblem(9, "Boolean");

$tests = array(1, "tariq", 1.5, true, 7, 's', false);

function showItem($item): string
{
    if (is_bool($item)) {            // is_bool بتفرّق بين true وبين 1
        return $item ? "Yes" : "No";
    }
    return (string)$item;
}

echo "-- for --\n";
for ($i = 0; $i < count($tests); $i++) {
    echo showItem($tests[$i]) . "\n";
}

echo "-- while --\n";
$i = 0;
while ($i < count($tests)) {
    echo showItem($tests[$i]) . "\n";
    $i++;
}
endProblem();


/* ============================================================
 * المسألة 10 (sorting)
 * ------------------------------------------------------------
 * معاك array من الأرقام ومهمتك ترتبه.
 *   input : $tests = array(6,4,9,3,12,8,7);
 *   output: 3 4 6 7 8 9 12
 * ============================================================ */
startProblem(10, "sorting");

$tests = array(6, 4, 9, 3, 12, 8, 7);

// الطريقة 1: الفانكشن الجاهزة
$copy = $tests;
sort($copy);
echo implode(" ", $copy) . "\n";

// الطريقة 2: بالـ RouteBubble من مسألة 5
echo implode(" ", RouteBubble($tests));
endProblem();


/* ============================================================
 * المسألة 11 (same values)
 * ------------------------------------------------------------
 * معاك 2 array، عاوزك تطلعلي كل المتشابهات بينهم.
 *   $arr1 = array('a','b','c','d');
 *   $arr2 = array('c','d','e','f');
 *   output: c - d
 * ============================================================ */
startProblem(11, "same values");

$arr1 = array('a', 'b', 'c', 'd');
$arr2 = array('c', 'd', 'e', 'f');

// الطريقة 1: يدوي بلوبين
$common = [];
foreach ($arr1 as $x) {
    foreach ($arr2 as $y) {
        if ($x === $y) {
            $common[] = $x;
            break;
        }
    }
}
echo implode(" - ", $common) . "\n";

// الطريقة 2: الفانكشن الجاهزة
echo implode(" - ", array_intersect($arr1, $arr2));
endProblem();


/* ============================================================
 * المسألة 12 (form — get / post)
 * ------------------------------------------------------------
 * البرنامج بيحسب السعر الكلي لقطع المنتج اللي العميل طلبها
 * وبيحسب قيمة الخصم (عملية مهمة في مواقع E-commerce).
 * الفورم فيه 2 inputs: سعر المنتج + عدد القطع.
 * بعد الـ submit اطبع السعر الكلي قبل وبعد الخصم.
 *   - السعر الكلي أقل من 1000ج => خصم 10%
 *   - السعر الكلي أكبر من 1000ج => خصم 15%
 *   - لو دخل رقم غلط (زي السالب) => رسالة خطأ واضحة
 *   - لو دخل حروف بدل الأرقام   => "لازم تدخل رقم" (is_numeric)
 * (الحل بيستخدم POST، والمعالجة في أول الملف)
 * ============================================================ */
?>
<div class="card">
    <h3>المسألة 12 — form (POST)</h3>

    <form method="post" action="">
        <label for="price">سعر المنتج (ج)</label>
        <input type="text" id="price" name="price" value="<?= e($price) ?>">

        <label for="quantity">عدد القطع</label>
        <input type="text" id="quantity" name="quantity" value="<?= e($quantity) ?>">

        <button type="submit">احسب</button>
    </form>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $err): ?>
                <p>⚠ <?= e($err) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($result): ?>
        <div class="result">
            السعر الكلي قبل الخصم: <b><?= number_format($result['total'], 2) ?> ج</b><br>
            نسبة الخصم: <b><?= $result['rate'] ?>%</b> (قيمة الخصم: <?= number_format($result['discount'], 2) ?> ج)<br>
            السعر الكلي بعد الخصم: <b><?= number_format($result['final'], 2) ?> ج</b>
        </div>
    <?php endif; ?>
</div>

</body>
</html>