ปีงบประมาณ  {{$fiscal_year}} 


$(document).ready(function() {
    $("#contract_mm").on("input", function() {
        var maxICT = parseFloat('{{ number_format($task->task_budget_it_operating) }}'.replace(/,/g , ""));
        var maxUtility = parseFloat('{{ number_format($task->task_budget_gov_utility) }}'.replace(/,/g , ""));
       
       
        var current = parseFloat($(this).val().replace(/,/g , ""));
        if (current > maxICT) {
            alert("จำนวนเงินที่ใส่ต้องไม่เกิน " + maxICT.toFixed(2) + " บาท (งบกลาง ICT)");
            $(this).val(maxICT.toFixed(2));
        }
    });

    $("#contract_PR").on("input", function() {
        var maxUtility = parseFloat('{{ number_format($task->task_budget_gov_utility) }}'.replace(/,/g , ""));
        var current = parseFloat($(this).val().replace(/,/g , ""));
        if (current > maxUtility) {
            alert("จำนวนเงินที่ใส่ต้องไม่เกิน " + maxUtility.toFixed(2) + " บาท (ค่าสาธารณูปโภค)");
            $(this).val(maxUtility.toFixed(2));
        }
    });
});


if (fieldId === "task_budget_it_investment") {
    max = parseFloat({{ number_format($task->task_budget_it_investment) }});
} else if (fieldId === "task_budget_gov_utility") {
    max = parseFloat({{ number_format($task->task_budget_gov_utility) }});
} else if (fieldId === "task_budget_it_operating") {
    max = parseFloat({{ number_format($task->task_budget_it_operating) }});
}

