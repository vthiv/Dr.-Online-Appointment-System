<?
include("../connection.php");

if(isset($_POST['dept_save']))
{
    $dept_id = $_POST['Dept_ID'];
    $dept_name = $_POST['Dept_Name'];
    $dept_description = $_POST['Dept_Description'];
    $dept_status = $_POST['Dept_Status'];

    $query = "INSERT INTO department(Dept_ID, Dept_Name, Dept_Description, Dept_Status) VALUES ('$dept_id', '$dept_name', '$dept_description', '$dept_status')";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['success'] = "New Department is Added";
        header("Location: departments_admin.php");
    }
    else
    {
        $_SESSION['status'] = "New Department is Not Added";
        header("Location: departments_admin.php");
    }
}
?>