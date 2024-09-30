<?php include 'header.php'; ?>

<div class="container mot-section">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center mb-5">MOT History for Vehicle <strong><?php echo $_GET['registration']; ?></strong></h1>

            <!-- MOT History Card -->
            <div class="mot-card" id="template-result">
                <div class="page-section bt-0">
                    <div class="section-heading">
                        <?php if (!empty($_GET['registration'])): ?>
                            <h5 class="mb-0 text-uppercase"><?php echo htmlspecialchars($_GET['registration']); ?></h5>
                        <?php endif; ?>

                        <?php if (!empty($_GET['registration']) && $data === null): ?>
                            <h1 class="vehicleName text-uppercase font-weight-bold mb-3">
                                No info regarding vehicle's registration number
                            </h1>
                        <?php else: ?>
                            <h1 class="text-uppercase font-weight-bold mb-3">
                                <?php if (empty($_GET['registration'])): ?>
                                    Toyota Prius
                                <?php else: ?>
                                    <?php echo htmlspecialchars($data['make'] . ' ' . $data['model']); ?>
                                <?php endif; ?>
                            </h1>
                        <?php endif; ?>

                        <a href="/" class="text-dark text-underline font-weight-bold mt-4">Check another vehicle</a>
                    </div>
                </div>

                <?php if (!empty($_GET['registration']) && $data !== null): ?>
                    <!-- MOT History -->
                    <div class="page-section">
                        <div class="section-heading">
                            <h5 class="text-primary font-weight-bold">MOT History</h5>
                            <?php
                                $latestMOT = !empty($data) && !empty($data['motTests']) ? $data['motTests'][0] : null;
                            ?>

                            <?php
                                $registrationDate = new DateTime($data['registrationDate']);
                                $currentDate = new DateTime();
                                $interval = $currentDate->diff($registrationDate);

                                $daysUntilMotExpiresForLessThan3years = floor((strtotime($data['motTestDueDate']) - time()) / (60 * 60 * 24));
                                $daysUntilMotExpires = floor((strtotime($latestMOT['expiryDate']) - time()) / (60 * 60 * 24));
                            ?>

                            <p class="mb-0 label">
                                <?php if ($interval->y < 3): ?>
                                    <?php if ($daysUntilMotExpiresForLessThan3years < 0): ?>
                                        MOT has expired
                                    <?php else: ?>  
                                        First MOT Due
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if ($daysUntilMotExpires < 0): ?>
                                        MOT has expired
                                    <?php else: ?>  
                                        MOT valid until
                                    <?php endif; ?>
                                <?php endif; ?>
                            </p>
                            
                            <?php if (empty($_GET['registration'])): ?>
                                <h5 class="font-weight-bold">06 February 2019</h5>
                            <?php else: ?>
                                <?php if ($interval->y < 3): ?>
                                    <?php if ($daysUntilMotExpiresForLessThan3years > 0): ?>
                                        <h5 class="font-weight-bold">
                                            <?php echo date("d F Y", strtotime($data['motTestDueDate'])); ?>
                                        </h5>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if ($daysUntilMotExpires > 0): ?>
                                        <h5 class="font-weight-bold">
                                            <?php echo date("d F Y", strtotime($latestMOT['expiryDate'])); ?>
                                        </h5>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php if (empty($_GET['registration'])): ?>
                                <p>MOT due in <strong>The MOT for this vehicle has expired 2060 days</strong></p>
                            <?php else: ?>
                                <?php if ($interval->y < 3): ?>
                                    <p>MOT due in <strong><?php echo floor((strtotime($data['motTestDueDate']) - time()) / (60 * 60 * 24)); ?> days</strong></p>
                                <?php else: ?>
                                    <p>MOT due in <strong><?php echo floor((strtotime($latestMOT['expiryDate']) - time()) / (60 * 60 * 24)); ?> days</strong></p>
                                <?php endif; ?>
                            <?php endif; ?>

                            <p class="mt-4">If you think the MOT expiry date or any of the vehicle details are wrong, 
                                <a href="https://www.gov.uk/contact-dvsa/y/mot-vehicle-tests-and-approval" 
                                    class="text-dark text-underline font-weight-bold">contact DVSA
                                </a>.
                            </p>
                            
                            <div class="border border-radius-5 mt-4">
                                <div class="p-3 border-bottom">
                                    <div class="motHistory clickable" onclick="toggleVisibility('mot-history')">
                                        <h6 class="font-weight-bold ">MOT history</h6>
                                        <p class="m-0">Check mileage recorded at test, MOT expiry date, defects and advisories, and view the test certificate.</p>
                                    </div>
                                
                                    <div class="mt-1" id="mot-history">
                                        <!-- Display static data if no reg no provided -->
                                        <?php if (empty($_GET['registration'])): ?>
                                            <div class="vehicle-info-row">
                                                <div>
                                                    <p class="label m-0">Date tested</p>
                                                    <h5 class="font-weight-bold m-0">07 February 2018</h5>
                                                    <h1 class="text-uppercase font-weight-bold text-green">passed</h1>
                                                </div>
                                                <div>
                                                    <p class="label m-0">Mileage</p>
                                                    <h5 class="font-weight-bold mt-0 mb-3">21,645</h5>
                                                    
                                                    <p class="label m-0">Expiry date</p>
                                                    <h5 class="font-weight-bold m-0">06 February 2019</h5>
                                                </div>
                                                <div>
                                                    <p class="label m-0">MOT test number</p>
                                                    <h5 class="font-weight-bold m-0">827555092722</h5>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <p>Monitor and repair if necessary (advisories):</p>
                                                <p onclick="toggleHelpContent(event)">
                                                    <label class="help-toggle" for="what-are-advisories-4">
                                                        What are advisories?
                                                    </label>
                                                </p>
                                                <div class="help-block-content">
                                                    Advisories are given for guidance. Some of these may need to be monitored 
                                                    in case they become more serious and need immediate repairs.
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <?php if ($interval->y < 3): ?>
                                                <h5 class="font-weight-bold mt-3">This vehicle hasn't had its first MOT.</h5>
                                            <?php else: ?>
                                                <!-- Display mot data -->
                                                <?php foreach ($data['motTests'] as $motTest): ?>
                                                    <div class="vehicle-info-row">
                                                        <div>
                                                            <p class="label m-0">Date tested</p>
                                                            <h5 class="font-weight-bold m-0"><?php echo date("d F Y", strtotime($motTest['completedDate'])); ?></h5>
                                                            <h1 class="text-uppercase font-weight-bold <?php echo $motTest['testResult'] === 'PASSED' ? 'text-green' : ''; ?>">
                                                                <?php echo htmlspecialchars($motTest['testResult']); ?>
                                                            </h1>
                                                        </div>

                                                        <div>
                                                            <p class="label m-0">Mileage</p>
                                                            <h5 class="font-weight-bold mt-0 mb-3"><?php echo number_format($motTest['odometerValue']); ?></h5>
                                                            
                                                            <p class="label m-0">Expiry date</p>
                                                            <h5 class="font-weight-bold m-0">
                                                                <?php echo $motTest['expiryDate'] !== null ? date("d F Y", strtotime($motTest['expiryDate'])) : '-'; ?>
                                                            </h5>
                                                        </div>
                                                        <div>
                                                            <p class="label m-0">MOT test number</p>
                                                            <h5 class="font-weight-bold m-0"><?php echo htmlspecialchars($motTest['motTestNumber']); ?></h5>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p>Monitor and repair if necessary (advisories):</p>
                                                        <ul>
                                                            <?php foreach ($motTest['defects'] as $defect): ?>
                                                                <li>
                                                                    <?php echo ($defect['dangerous'] ? '<strong>[Dangerous]</strong> ' : '') . $defect['text']; ?>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>

                                                        <p onclick="toggleHelpContent(event)">
                                                            <label class="help-toggle" for="what-are-advisories-4">
                                                                What are advisories?
                                                            </label>
                                                        </p>
                                                        <div class="help-block-content">
                                                            Advisories are given for guidance. Some of these may need to be monitored 
                                                            in case they become more serious and need immediate repairs.
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <h5 class="font-weight-bold">The MOT test changed on 20 May 2018</h5>
                                        <p class="mb-0">Defects are now categorised according to their severity – dangerous, 
                                            major, and minor. 
                                            <a href="https://www.gov.uk/government/news/mot-changes-20-may-2018"
                                                class="text-dark text-underline font-weight-bold">
                                                Find out more
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <div class="outstandingRecalls clickable" onclick="toggleVisibility('outstanding-recall')">
                                        <h6 class="font-weight-bold">Outstanding vehicle recalls</h6>
                                        <p class="m-0">
                                            <?php if (empty($_GET['registration'])): ?>
                                                Check if TOYOTA PRIUS () has outstanding recalls
                                            <?php else: ?>
                                                Check if <?php echo htmlspecialchars($data['make'] . ' ' . $data['model']); ?> (<?php echo htmlspecialchars($data['registration']); ?>) 
                                                has outstanding recalls
                                            <?php endif; ?>
                                        </p>
                                    </div>

                                    <div class="mt-3" id="outstanding-recall">
                                        <?php if (empty($_GET['registration'])): ?>
                                            <h6 class="font-weight-bold text-green">No outstanding safety recalls found</h6>
                                        <?php else: ?>
                                            <?php if ($data['hasOutstandingRecall'] !== 'Unknown'): ?>
                                                <h6 class="font-weight-bold">There are outstanding recalls for this vehicle. Please contact the manufacturer for more information</h6>
                                            <?php else: ?>
                                                <h6 class="font-weight-bold text-green">No outstanding safety recalls found</h6>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <p class="mb-0">This information is provided by the vehicle manufacturer. If you think the information is wrong, contact the vehicle manufacturer's dealership.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle Information Section -->
                    <div class="page-section">
                        <div class="section-heading">
                            <h5 class="text-primary font-weight-bold">Vehicle Information</h5>
                            <div class="vehicle-info-row">
                                <div>
                                    <p class="label m-0">Colour</p>
                                    <?php if (empty($_GET['registration'])): ?>
                                        <h5 class="font-weight-bold m-0">White</h5>
                                    <?php else: ?>
                                        <h5 class="font-weight-bold m-0"><?php echo htmlspecialchars($data['primaryColour']); ?></h5>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="label m-0">Fuel Type</p>
                                    <?php if (empty($_GET['registration'])): ?>
                                        <h5 class="font-weight-bold m-0">Hybrid Electric (Clean)</h5>
                                    <?php else: ?>
                                        <h5 class="font-weight-bold m-0"><?php echo htmlspecialchars($data['fuelType']); ?></h5>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="label m-0">Date Registered</p>
                                    <?php if (empty($_GET['registration'])): ?>
                                        <h5 class="font-weight-bold m-0">26 October 2014</h5>
                                    <?php else: ?>
                                        <h5 class="font-weight-bold m-0"><?php echo date("d F Y", strtotime($data['registrationDate'])); ?></h5>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Back to Search Button -->
            <div class="text-center mt-5">
                <a href="/" class="btn btn-primary">Check Another Vehicle</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
