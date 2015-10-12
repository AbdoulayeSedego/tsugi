<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\Mersenne_Twister;

// Compute the stuff for the output
$code = $USER->id+$LINK->id+$CONTEXT->id;
$MT = new Mersenne_Twister($code);

// Every 10th line, 1-3 numbers 0-9999 each
$maxlines = 400;
$sum = 42;
for($line=0; $line<$maxlines;$line++) {
    $choose = $MT->getNext(0,9);
    if ( $choose != 0 ) continue;
    $howmany = $MT->getNext(1,3);
    for($nums=0;$nums<$howmany;$nums++) {
        $sum = $sum + $MT->getNext(1,10000);
    }
}

$sum_sample = 42;
$MT = new Mersenne_Twister(42);
for($line=0; $line<$maxlines;$line++) {
    $choose = $MT->getNext(0,9);
    if ( $choose != 0 ) continue;
    $howmany = $MT->getNext(1,3);
    for($nums=0;$nums<$howmany;$nums++) {
        $sum_sample = $sum_sample + $MT->getNext(1,10000);
    }
}

$oldgrade = $RESULT->grade;
if ( isset($_POST['sum']) ) {
    if ( $_POST['sum'] != $sum ) {
        $_SESSION['error'] = "Your sum did not match";
        header('Location: '.addSession('index.php'));
        return;
    }

    LTIX::gradeSendDueDate(1.0, $oldgrade, $dueDate);
    // Redirect to ourself
    header('Location: '.addSession('index.php'));
    return;
}

// echo($goodsha);
if ( $LINK->grade > 0 ) {
    echo('<p class="alert alert-info">Your current grade on this assignment is: '.($LINK->grade*100.0).'%</p>'."\n");
}

if ( $dueDate->message ) {
    echo('<p style="color:red;">'.$dueDate->message.'</p>'."\n");
}
?>
<p>
<b>Funding Numbers in a Haystack</b>
<form method="post">
This assignment is from Chapter 11 - Regular Expressions in 
<a href="http://www.pythonlearn.com/book.php" target="_blank">Python for Informatics: Exploring Information</a>.
In this assignment you will read through and parse a file with text and numbers.  You will extract all the numbers
in the file and compute the sum of the numbers and enter the sum below:
<input type="text" size="80" name="sum">
<input type="submit">
</form>
</p>
<b>Data Files</b>
<p>
We provide two files for this assignment.  One is a sample file where we give you the sum for your
testing and the other is the actual data you need to process for the assignment.  
<ul>
<li> <a href="data/assn_11_sample.txt" target="_blank">Download sample data</a> (Sum=<?= $sum_sample ?>) </li>
<li> <a href="data/assn_11_actual.txt" target="_blank">Download the actual data</a> (Sum ends with <?= $sum%100 ?>)<br/> </li>
</ul>
These links open in a new window.
Make sure to save the file into the same folder as you will be writing your Python program.
<b>Note:</b> Each student will have a distinct data file for the assignment - so only use your
own data file for analysis.
</p>
<b>Data Format</b>
<p>
The file contains much of the text from the introduction of the textbook
except that random numbers are inserted throughout the text.  Here is a sample of the output you might see:
<pre>
Why should you learn to write programs? 7746
12 1929 8827
Writing programs (or programming) is a very creative 
7 and rewarding activity.  You can write programs for 
many reasons, ranging from making your living to solving
8837 a difficult data analysis problem to having fun to helping 128
someone else solve a problem.  This book assumes that 
everyone needs to know how to program ...
</pre>
The sum for the sample text above is <b>27486</b>.
The numbers can appear anywhere in the line.  There can be any number of 
numbers in each line (including none).
</p>
<b>Handling The Data</b>
<p>
The basic outline of this problem is to read the file, look for integers using the
<b>re.findall()</b>, looking for a regular expression of <b>'[0-9]+'</b> and then 
converting the extracted strings to integers and summing up the integers.
</p>
<b>Just for Fun</b>
<p>
There are a number of different ways to approach this problem.  While we don't recommend trying
to write the most compact code possible, it can sometimes be a fun exercise.  Here is a 
a redacted version of two-line version of this program using list comprehension:
<pre>
import re
print sum( [ ****** *** * in **********('[0-9]+',**************************.read()) ] )
</pre>
Please don't waste a lot of time trying to figure out the shortest solution until you 
have completed the homework.   List comprehension is mentioned in Chapter 10 and the 
<b>read()</b> method is covered in Chapter 7.
</p>

